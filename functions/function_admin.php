<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['sesi_role'], $_SESSION['sesi_id'])) {
	header('Location: ../auth/login.php');
	exit();
}

$sesi_role = $_SESSION['sesi_role'];
$sesi_id   = (int)$_SESSION['sesi_id'];

// Hanya boleh diakses lewat POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: ../dashboard');
	exit();
}

/*
|--------------------------------------------------------------------------
| REGISTRASI USER BARU (Admin menambahkan akun)
|--------------------------------------------------------------------------
*/
if (isset($_POST['btn_adminregister'])) {
	// Ambil data dari form
	$nama_user  = htmlspecialchars(trim($_POST['nama_user'] ?? ''), ENT_QUOTES, 'UTF-8');
	$email      = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
	$username   = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
	$password   = trim($_POST['password'] ?? '');
	$konfirmasi = trim($_POST['konfirmasi_password'] ?? '');
	$role       = htmlspecialchars(trim($_POST['role'] ?? ''), ENT_QUOTES, 'UTF-8');
	$no_telp    = htmlspecialchars(trim($_POST['no_telp'] ?? ''), ENT_QUOTES, 'UTF-8');
	$alamat     = htmlspecialchars(trim($_POST['alamat'] ?? ''), ENT_QUOTES, 'UTF-8');

	// Simpan input sementara jika terjadi error
	$_SESSION['form_data'] = [
		'nama_user' => $nama_user,
		'email'     => $email,
		'username'  => $username,
		'role'      => $role,
		'no_telp'   => $no_telp,
		'alamat'    => $alamat
	];

	// Validasi dasar
	if ($nama_user === '' || $email === '' || $username === '' || $password === '' || $role === '') {
		header('Location: ../dashboard/admin?page=register user&status=error&msg=Data tidak lengkap');
		exit();
	}

	// Cek apakah username sudah digunakan
	$cek = mysqli_query($koneksi, "SELECT id_user FROM users WHERE username = '$username' LIMIT 1");
	if (mysqli_num_rows($cek) > 0) {
		header('Location: ../dashboard/admin?page=register user&status=warning&msg=Username sudah digunakan');
		exit();
	}

	// Validasi password
	if ($password !== $konfirmasi) {
		header('Location: ../dashboard/admin?page=register user&status=warning&msg=Password tidak sama');
		exit();
	}

	// Simpan data user baru ke database (tanpa hash agar konsisten dengan login sistem)
	$query = "
        INSERT INTO users (nama_user, email, username, password, role, no_telp, alamat)
        VALUES ('$nama_user', '$email', '$username', '$password', '$role', '$no_telp', '$alamat')
    ";

	if (mysqli_query($koneksi, $query)) {
		unset($_SESSION['form_data']);
		header('Location: ../dashboard/admin?page=data user&status=success&action=register');
		exit();
	} else {
		$error = mysqli_error($koneksi);
		header('Location: ../dashboard/admin?page=register user&status=error&msg=' . urlencode($error));
		exit();
	}
}


/*
|--------------------------------------------------------------------------
| EDIT DATA AKUN (nama, email, username, role, no_telp, alamat, password)
|--------------------------------------------------------------------------
*/
if (isset($_POST['btn_editdataakun'])) {
	$id_user       = (int)($_POST['id_user'] ?? 0);
	$username_lama = htmlspecialchars(trim($_POST['username_lama'] ?? ''), ENT_QUOTES, 'UTF-8');

	// Ambil data dari form
	$nama_user  = htmlspecialchars(trim($_POST['nama_user'] ?? ''), ENT_QUOTES, 'UTF-8');
	$email      = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
	$username   = htmlspecialchars(trim($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8');
	$role       = htmlspecialchars(trim($_POST['role'] ?? ''), ENT_QUOTES, 'UTF-8');
	$no_telp    = htmlspecialchars(trim($_POST['no_telp'] ?? ''), ENT_QUOTES, 'UTF-8');
	$alamat     = htmlspecialchars(trim($_POST['alamat'] ?? ''), ENT_QUOTES, 'UTF-8');
	$password   = trim($_POST['password'] ?? '');
	$konfirmasi = trim($_POST['konfirmasi_password'] ?? '');

	// Validasi dasar
	if ($nama_user === '' || $email === '' || $username === '') {
		header("Location: ../dashboard/admin?page=profile&id={$id_user}&action=invalid&status=warning");
		exit();
	}

	// Cek username sudah dipakai user lain atau belum
	$sqlCek = mysqli_query(
		$koneksi,
		"SELECT id_user FROM users 
         WHERE username = '$username' 
           AND id_user <> '$id_user'
         LIMIT 1"
	);
	if ($sqlCek && mysqli_num_rows($sqlCek) > 0) {
		header("Location: ../dashboard/admin?page=profile&id={$id_user}&action=userexist&status=warning");
		exit();
	}

	// Siapkan bagian query SET
	$setPart = "
        nama_user = '$nama_user',
        email     = '$email',
        username  = '$username',
        no_telp   = '$no_telp',
        alamat    = '$alamat'
    ";

	if ($role !== '') {
		$setPart .= ", role = '$role'";
	}

	// Jika password diisi, pastikan sama dengan konfirmasi
	if ($password !== '' || $konfirmasi !== '') {
		if ($password !== $konfirmasi) {
			header("Location: ../dashboard/admin?page=profile&id={$id_user}&action=passwordnotsame&status=warning");
			exit();
		}
		$setPart .= ", password = '$password'";
	}

	$query_update = "UPDATE users SET $setPart WHERE id_user = '$id_user'";
	$update = mysqli_query($koneksi, $query_update);

	if ($update) {
		// Update session jika user mengedit dirinya sendiri
		if ($id_user === $sesi_id) {
			$_SESSION['sesi_nama']     = $nama_user;
			$_SESSION['sesi_username'] = $username;
			$_SESSION['sesi_role']     = $role;
		}

		// Redirect berdasarkan siapa yang melakukan edit
		if ($sesi_role === 'admin') {
			if ($id_user === $sesi_id) {
				header("Location: ../dashboard/admin?page=profile&id={$id_user}&action=edituser&status=success");
				exit();
			} else {
				header("Location: ../dashboard/admin?page=data user&action=edituser&status=success");
				exit();
			}
		} elseif ($sesi_role === 'klien') {
			header("Location: ../dashboard/klien?page=profile&action=edituser&status=success");
			exit();
		} else {
			header('Location: ../dashboard');
			exit();
		}
	} else {
		$error = mysqli_error($koneksi);
		if ($sesi_role === 'admin') {
			if ($id_user === $sesi_id) {
				header("Location: ../dashboard/admin?page=profile&id={$id_user}&action=edituser&status=error&message=" . urlencode($error));
			} else {
				header("Location: ../dashboard/admin?page=data user&action=edituser&status=error&message=" . urlencode($error));
			}
		} elseif ($sesi_role === 'klien') {
			header("Location: ../dashboard/klien?page=profile&action=edituser&status=error&message=" . urlencode($error));
		} else {
			header('Location: ../dashboard');
		}
		exit();
	}
}

/*
|--------------------------------------------------------------------------
| HAPUS AKUN
|--------------------------------------------------------------------------
*/
if (isset($_POST['btn_deleteakun'])) {
	$id_user = (int)($_POST['id_user'] ?? 0);

	if ($id_user <= 0) {
		header("Location: ../dashboard/{$sesi_role}?page=profile&action=deleteuser&status=error");
		exit();
	}

	$query_hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_user'");

	if ($query_hapus) {
		if ($id_user === $sesi_id) {
			header('Location: ../auth/logout.php');
			exit();
		}

		if ($sesi_role === 'admin') {
			header('Location: ../dashboard/admin?page=data user&action=deleteuser&status=success');
		} else {
			header("Location: ../dashboard/{$sesi_role}?page=profile&action=deleteuser&status=success");
		}
		exit();
	} else {
		$error = mysqli_error($koneksi);
		header("Location: ../dashboard/{$sesi_role}?page=profile&action=deleteuser&status=error&message=" . urlencode($error));
		exit();
	}
}

// Default redirect
header('Location: ../dashboard');
exit();
