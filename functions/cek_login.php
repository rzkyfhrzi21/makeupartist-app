<?php
session_start();
include 'koneksi.php';

// ==== LOGIN ====
if (isset($_POST['btn_login'])) {
	$username = mysqli_real_escape_string($koneksi, $_POST['username']);
	$password = mysqli_real_escape_string($koneksi, $_POST['password']);

	// Ambil user berdasarkan username
	$sql_login   = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
	$data_user   = mysqli_fetch_assoc($sql_login);

	if ($data_user) {
		// Cocokkan password
		// Jika belum hash, gunakan pembanding biasa.
		// Jika nanti sudah pakai password_hash(), ubah jadi password_verify($password, $data_user['password'])
		if ($data_user['password'] === $password) {

			// Set session
			$_SESSION['sesi_id']       = $data_user['id_user'];
			$_SESSION['sesi_role']     = $data_user['role'];
			$_SESSION['sesi_username'] = $data_user['username'];
			$_SESSION['sesi_nama']     = $data_user['nama_user'];
			$_SESSION['sesi_email']    = $data_user['email'];

			// Arahkan sesuai role
			if ($data_user['role'] === 'admin') {
				header('Location: ../dashboard/admin');
				exit();
			} elseif ($data_user['role'] === 'klien') {
				header('Location: ../dashboard/klien');
				exit();
			} else {
				header('Location: ../auth/login?action=role_invalid&status=error');
				exit();
			}
		} else {
			// Password salah
			header("Location: ../auth/login?action=wrongpassword&status=error");
			exit();
		}
	} else {
		// Username tidak ditemukan
		header("Location: ../auth/login?action=usernotfound&status=error");
		exit();
	}
}

// ==== REGISTER ====
if (isset($_POST['btn_register'])) {
	$nama_user           = htmlspecialchars(trim($_POST['nama_user']));
	$username            = htmlspecialchars(trim($_POST['username']));
	$password            = $_POST['password'];
	$konfirmasi_password = $_POST['konfirmasi_password'];
	$role                = 'klien'; // default untuk user baru

	// Cek username sudah digunakan atau belum
	$cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
	$jumlah   = mysqli_num_rows($cek_user);

	if ($password !== $konfirmasi_password) {
		header("Location: ../auth/register?action=passwordnotsame&status=warning&username=$username&nama_user=$nama_user");
		exit();
	}

	if ($jumlah > 0) {
		header("Location: ../auth/register?action=userexist&status=warning&nama_user=$nama_user");
		exit();
	}

	// Jika aman, insert user baru
	$query_daftar = "
        INSERT INTO users (nama_user, username, password, role)
        VALUES ('$nama_user', '$username', '$password', '$role')
    ";
	$daftar = mysqli_query($koneksi, $query_daftar);

	if ($daftar) {
		header("Location: ../auth/login?action=registered&status=success");
		exit();
	} else {
		header("Location: ../auth/register?action=failed&status=error");
		exit();
	}
}
