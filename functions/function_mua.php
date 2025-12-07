<?php
include 'koneksi.php';
session_start();
ob_start();

/* ===========================================================
   =============== 1. Fungsi Upload Banyak Gambar =============
   =========================================================== */
function uploadGambarGaleriMultiple($files)
{
	$uploaded = [];
	$valid_ext = ['jpg', 'jpeg', 'png', 'webp'];

	foreach ($files['name'] as $index => $nama_file) {
		if ($files['error'][$index] !== UPLOAD_ERR_OK) {
			continue;
		}

		$tmp_name = $files['tmp_name'][$index];
		$ukuran   = $files['size'][$index];
		$ext      = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

		if (!in_array($ext, $valid_ext)) {
			continue; // lewati file tidak valid
		}

		if ($ukuran > 1000000) {
			continue; // lewati jika lebih dari 1MB
		}

		$nama_baru = uniqid('mua_', true) . '.' . $ext;
		$target = '../dashboard/assets/paket_mua/' . $nama_baru;

		if (move_uploaded_file($tmp_name, $target)) {
			$uploaded[] = $nama_baru;
		}
	}

	return $uploaded;
}

/* ===========================================================
   =============== 2. Tambah Layanan + Upload Foto ============
   =========================================================== */
if (isset($_POST['btn_tambahlayanan'])) {
	$nama_service        = htmlspecialchars(trim($_POST['nama_service']));
	$deskripsi_singkat   = htmlspecialchars(trim($_POST['deskripsi_singkat']));
	$deskripsi_lengkap   = htmlspecialchars(trim($_POST['deskripsi_lengkap']));
	$harga_mulai         = htmlspecialchars(trim($_POST['harga_mulai']));
	$estimasi_durasi     = htmlspecialchars(trim($_POST['estimasi_durasi']));

	// Simpan sementara ke session jika validasi gagal
	$_SESSION['form_service'] = [
		'nama_service' => $nama_service,
		'deskripsi_singkat' => $deskripsi_singkat,
		'deskripsi_lengkap' => $deskripsi_lengkap,
		'harga_mulai' => $harga_mulai,
		'estimasi_durasi' => $estimasi_durasi,
	];

	// Validasi minimal
	if (empty($nama_service) || empty($deskripsi_singkat) || empty($harga_mulai)) {
		header("Location: ../dashboard/admin.php?page=tambah mua&status=error&msg=Data tidak lengkap");
		exit();
	}

	// Pastikan minimal 1 gambar diupload
	if (!isset($_FILES['gambar']) || count(array_filter($_FILES['gambar']['name'])) == 0) {
		header("Location: ../dashboard/admin.php?page=tambah mua&status=error&msg=Minimal 1 gambar wajib diunggah");
		exit();
	}

	// Insert ke database services
	$query_service = "
        INSERT INTO services (nama_service, deskripsi_singkat, deskripsi_lengkap, harga_mulai, estimasi_durasi)
        VALUES ('$nama_service', '$deskripsi_singkat', '$deskripsi_lengkap', '$harga_mulai', '$estimasi_durasi')
    ";

	if (mysqli_query($koneksi, $query_service)) {
		$id_service = mysqli_insert_id($koneksi); // Ambil ID layanan baru

		// Upload semua gambar dan simpan ke tabel gallery
		$gambar_uploaded = uploadGambarGaleriMultiple($_FILES['gambar']);

		if (!empty($gambar_uploaded)) {
			foreach ($gambar_uploaded as $g) {
				mysqli_query($koneksi, "
                    INSERT INTO gallery (id_service, gambar, deskripsi, created_at)
                    VALUES ('$id_service', '$g', '', NOW())
                ");
			}
		}

		unset($_SESSION['form_service']);
		header("Location: ../dashboard/admin.php?page=detail mua&id=$id_service&status=success&action=tambah");
		exit();
	} else {
		$error = mysqli_error($koneksi);
		header("Location: ../dashboard/admin.php?page=tambah mua&status=error&msg=" . urlencode($error));
		exit();
	}
}

/* ===========================================================
   =============== 3. Tambah Booking (Klien) =================
   =========================================================== */
if (isset($_POST['btn_tambahbooking'])) {
	$id_user         = htmlspecialchars(trim($_POST['id_user']));
	$id_service      = htmlspecialchars(trim($_POST['id_service']));
	$tanggal_booking = htmlspecialchars(trim($_POST['tanggal_booking']));
	$waktu_booking   = htmlspecialchars(trim($_POST['waktu_booking']));
	$lokasi          = htmlspecialchars(trim($_POST['lokasi']));
	$catatan_klien   = htmlspecialchars(trim($_POST['catatan_klien']));
	$total_harga     = htmlspecialchars(trim($_POST['total_harga']));
	$status          = 'pending';

	// Validasi dasar
	if (empty($id_service) || empty($lokasi) || empty($tanggal_booking) || empty($waktu_booking)) {
		header("Location: ../dashboard/klien?page=booking&id_service=$id_service&status=error&msg=" . urlencode('Data tidak lengkap.'));
		exit();
	}

	// Simpan ke database
	$query = "
        INSERT INTO bookings (id_user, id_service, tanggal_booking, waktu_booking, lokasi, catatan_klien, status, total_harga)
        VALUES ('$id_user', '$id_service', '$tanggal_booking', '$waktu_booking', '$lokasi', '$catatan_klien', '$status', '$total_harga')
    ";

	if (mysqli_query($koneksi, $query)) {
		header("Location: ../dashboard/klien?page=riwayat booking mua&status=success&action=tambahbooking");
		exit();
	} else {
		$error = mysqli_error($koneksi);
		header("Location: ../dashboard/klien?page=booking&id_service=$id_service&status=error&msg=" . urlencode($error));
		exit();
	}
}

/* ===========================================================
   =============== 4. Edit Layanan ============================
   =========================================================== */
if (isset($_POST['btn_editlayanan'])) {
	$id_service        = htmlspecialchars(trim($_POST['id_service']));
	$nama_service      = htmlspecialchars(trim($_POST['nama_service']));
	$harga_mulai       = htmlspecialchars(trim($_POST['harga_mulai']));
	$estimasi_durasi   = htmlspecialchars(trim($_POST['estimasi_durasi']));
	$deskripsi_singkat = htmlspecialchars(trim($_POST['deskripsi_singkat']));
	$deskripsi_lengkap = htmlspecialchars(trim($_POST['deskripsi_lengkap']));

	$query = "
        UPDATE services SET 
            nama_service = '$nama_service',
            harga_mulai = '$harga_mulai',
            estimasi_durasi = '$estimasi_durasi',
            deskripsi_singkat = '$deskripsi_singkat',
            deskripsi_lengkap = '$deskripsi_lengkap'
        WHERE id_service = '$id_service'
    ";

	if (mysqli_query($koneksi, $query)) {
		header("Location: ../dashboard/admin.php?page=detail mua&id=$id_service&status=success&action=edit");
		exit();
	} else {
		$error = mysqli_error($koneksi);
		header("Location: ../dashboard/admin.php?page=detail mua&id=$id_service&status=error&msg=" . urlencode($error));
		exit();
	}
}

/* ===========================================================
   =============== 5. Upload Gambar Galeri Tambahan ===========
   =========================================================== */
if (isset($_POST['upload_imggaleri'])) {
	$id_service = htmlspecialchars(trim($_POST['id_service']));
	$deskripsi  = htmlspecialchars(trim($_POST['deskripsi']));

	$gambar_uploaded = uploadGambarGaleriMultiple($_FILES['gambar']);
	if (!empty($gambar_uploaded)) {
		foreach ($gambar_uploaded as $g) {
			mysqli_query($koneksi, "
                INSERT INTO gallery (id_service, gambar, deskripsi, created_at)
                VALUES ('$id_service', '$g', '$deskripsi', NOW())
            ");
		}
		header("Location: ../dashboard/admin.php?page=detail mua&id=$id_service&status=success&action=upload");
		exit();
	} else {
		header("Location: ../dashboard/admin.php?page=detail mua&id=$id_service&status=error&msg=gagal_upload");
		exit();
	}
}

/* ===========================================================
   =============== 6. Hapus Gambar Galeri =====================
   =========================================================== */
if (isset($_POST['btn_deleteimg'])) {
	$id_gallery = htmlspecialchars(trim($_POST['id_galerihapus']));
	$gambar     = htmlspecialchars(trim($_POST['gambar_hapus']));

	$q = mysqli_query($koneksi, "SELECT id_service FROM gallery WHERE id_gallery = '$id_gallery'");
	$data = mysqli_fetch_assoc($q);
	$id_service = $data ? $data['id_service'] : 0;

	$query = "DELETE FROM gallery WHERE id_gallery = '$id_gallery'";
	if (mysqli_query($koneksi, $query)) {
		$path = '../dashboard/assets/paket_mua/' . $gambar;
		if (file_exists($path)) unlink($path);

		header("Location: ../dashboard/admin.php?page=detail mua&id=$id_service&status=success&action=deleteimg");
		exit();
	} else {
		$error = mysqli_error($koneksi);
		header("Location: ../dashboard/admin.php?page=detail mua&id=$id_service&status=error&msg=" . urlencode($error));
		exit();
	}
}

/* ===========================================================
   =============== 7. Hapus Data Layanan ======================
   =========================================================== */
if (isset($_POST['btn_deletelayanan'])) {
	$id_service = htmlspecialchars(trim($_POST['id_service']));

	$get = mysqli_query($koneksi, "SELECT gambar FROM gallery WHERE id_service = '$id_service'");
	while ($row = mysqli_fetch_assoc($get)) {
		$path = '../dashboard/assets/paket_mua/' . $row['gambar'];
		if (file_exists($path)) unlink($path);
	}
	mysqli_query($koneksi, "DELETE FROM gallery WHERE id_service = '$id_service'");

	$query = "DELETE FROM services WHERE id_service = '$id_service'";
	if (mysqli_query($koneksi, $query)) {
		header("Location: ../dashboard/admin.php?page=list mua&status=success&action=delete");
		exit();
	} else {
		$error = mysqli_error($koneksi);
		header("Location: ../dashboard/admin.php?page=list mua&status=error&msg=" . urlencode($error));
		exit();
	}
}

ob_end_flush();
