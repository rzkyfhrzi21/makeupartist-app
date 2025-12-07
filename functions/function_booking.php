<?php
session_start();
include 'koneksi.php';

// Hindari output sebelum header()
ob_start();

/*
|-------------------------------------------------------------------------- 
| HAPUS BOOKING
|-------------------------------------------------------------------------- 
*/
if (isset($_POST['btn_hapusbooking'])) {
    $id_booking = htmlspecialchars(trim($_POST['id_booking']));

    $query = "DELETE FROM bookings WHERE id_booking = '$id_booking'";
    $hapus = mysqli_query($koneksi, $query);

    if ($hapus) {
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=hapusbooking&status=success');
    } else {
        $error = mysqli_error($koneksi);
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=hapusbooking&status=error&message=' . urlencode($error));
    }
    exit();
}

/*
|-------------------------------------------------------------------------- 
| KONFIRMASI / UPDATE STATUS BOOKING (ADMIN)
|-------------------------------------------------------------------------- 
| Tombol ini dikirim dari riwayat_booking_mua.php untuk ubah status:
| pending → dikonfirmasi → selesai
*/
if (isset($_POST['btn_updatestatus'])) {
    $id_booking = htmlspecialchars(trim($_POST['id_booking']));
    $status     = htmlspecialchars(trim($_POST['status']));

    $allowed_status = ['pending', 'dikonfirmasi', 'selesai'];
    if (!in_array($status, $allowed_status)) {
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=updatestatus&status=error&message=Status tidak valid');
        exit();
    }

    $query = "UPDATE bookings SET status = '$status' WHERE id_booking = '$id_booking'";
    $update = mysqli_query($koneksi, $query);

    if ($update) {
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=updatestatus&status=success');
    } else {
        $error = mysqli_error($koneksi);
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=updatestatus&status=error&message=' . urlencode($error));
    }
    exit();
}

/*
|-------------------------------------------------------------------------- 
| TAMBAH BOOKING BARU (KLIEN)
|-------------------------------------------------------------------------- 
*/
if (isset($_POST['btn_tambahbooking'])) {
    $id_user         = htmlspecialchars(trim($_SESSION['sesi_id']));
    $id_service      = htmlspecialchars(trim($_POST['id_service']));
    $tanggal_booking = date('Y-m-d');
    $waktu_booking   = htmlspecialchars(trim($_POST['waktu_booking']));
    $lokasi          = htmlspecialchars(trim($_POST['lokasi']));
    $catatan_klien   = htmlspecialchars(trim($_POST['catatan_klien']));
    $total_harga     = htmlspecialchars(trim($_POST['total_harga']));
    $status          = 'pending';

    if (empty($id_service) || empty($lokasi) || empty($waktu_booking)) {
        header('Location: ../dashboard/klien?page=booking&action=tambahbooking&status=error&message=' . urlencode('Data tidak lengkap.'));
        exit();
    }

    $query = "INSERT INTO bookings (id_user, id_service, tanggal_booking, waktu_booking, lokasi, catatan_klien, status, total_harga)
              VALUES ('$id_user', '$id_service', '$tanggal_booking', '$waktu_booking', '$lokasi', '$catatan_klien', '$status', '$total_harga')";

    if (mysqli_query($koneksi, $query)) {
        header('Location: ../dashboard/klien?page=riwayat booking&action=tambahbooking&status=success');
    } else {
        $error = mysqli_error($koneksi);
        header('Location: ../dashboard/klien?page=booking&action=tambahbooking&status=error&message=' . urlencode($error));
    }
    exit();
}

/*
|-------------------------------------------------------------------------- 
| EDIT DATA BOOKING (ADMIN)
|-------------------------------------------------------------------------- 
*/
if (isset($_POST['btn_editbooking'])) {
    $id_booking     = htmlspecialchars(trim($_POST['id_booking']));
    $waktu_booking  = htmlspecialchars(trim($_POST['waktu_booking']));
    $lokasi         = htmlspecialchars(trim($_POST['lokasi']));
    $catatan_klien  = htmlspecialchars(trim($_POST['catatan_klien']));
    $status         = htmlspecialchars(trim($_POST['status']));

    $allowed_status = ['pending', 'dikonfirmasi', 'selesai'];
    if (!in_array($status, $allowed_status)) {
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=editbooking&status=error&message=Status tidak valid');
        exit();
    }

    $query = "UPDATE bookings 
              SET waktu_booking='$waktu_booking', 
                  lokasi='$lokasi', 
                  catatan_klien='$catatan_klien', 
                  status='$status' 
              WHERE id_booking='$id_booking'";

    if (mysqli_query($koneksi, $query)) {
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=editbooking&status=success');
    } else {
        $error = mysqli_error($koneksi);
        header('Location: ../dashboard/admin?page=riwayat booking mua&action=editbooking&status=error&message=' . urlencode($error));
    }
    exit();
}

/*
|-------------------------------------------------------------------------- 
| TANDAI BOOKING SELESAI (KLIEN)
|-------------------------------------------------------------------------- 
| Klien hanya bisa ubah status ke "selesai" jika status saat ini "dikonfirmasi"
*/
if (isset($_POST['btn_selesaikan'])) {
    $id_booking = (int)($_POST['id_booking'] ?? 0);

    if ($id_booking <= 0) {
        header('Location: ../dashboard/klien?page=riwayat booking mua&status=error');
        exit();
    }

    $update = mysqli_query($koneksi, "
        UPDATE bookings 
        SET status = 'selesai' 
        WHERE id_booking = '$id_booking' 
        AND status = 'dikonfirmasi'
    ");

    if ($update) {
        header('Location: ../dashboard/klien?page=riwayat booking mua&action=selesaikan&status=success');
    } else {
        $error = mysqli_error($koneksi);
        header('Location: ../dashboard/klien?page=riwayat booking mua&action=selesaikan&status=error&message=' . urlencode($error));
    }
    exit();
}

// Tutup output buffer
ob_end_flush();
