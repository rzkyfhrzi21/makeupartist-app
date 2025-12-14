<?php
session_start();

$usernameLogin  = isset($_GET['username']) ? $_GET['username'] : '';
$nama_userLogin = isset($_GET['nama_user']) ? $_GET['nama_user'] : '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title>Registrasi - Makeup Artist Yola</title>

    <link rel="shortcut icon" href="../dashboard/assets/pmi.png" type="image/x-icon">
    <link rel="stylesheet" href="../dashboard/assets/compiled/css/app.css">
    <link rel="stylesheet" href="../dashboard/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="../dashboard/assets/compiled/css/auth.css">
    <link rel="stylesheet" href="../dashboard/assets/extensions/sweetalert2/sweetalert2.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #fbe4ec, #fdf0f4);
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            margin: 0;
        }

        #auth {
            background-color: rgba(255, 255, 255, 0.96);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            max-width: 420px;
            width: 100%;
        }

        .auth-title {
            color: #d63384 !important;
            font-weight: 700;
        }

        .btn-primary,
        .btn-danger {
            background-color: #d63384 !important;
            border-color: #d63384 !important;
        }

        .btn-primary:hover,
        .btn-danger:hover {
            background-color: #b52c6e !important;
        }

        label {
            font-size: 14px;
        }

        .text-danger {
            color: #d63384 !important;
        }

        .form-control:focus {
            border-color: #d63384;
            box-shadow: 0 0 0 0.25rem rgba(214, 51, 132, 0.2);
        }
    </style>
</head>

<body>
    <script src="../dashboard/assets/static/js/initTheme.js"></script>

    <div id="app">
        <div class="content-wrapper container">
            <div class="row h-100 justify-content-center">
                <div class="card mt-5 shadow-lg" id="auth">
                    <div class="card-header text-center">
                        <h2 class="auth-title">Daftar Akun MUA Yola</h2>
                        <p class="auth-subtitle text-muted mb-2">
                            Yuk, jadi bagian dari <b>Makeup Artist Yola</b> 💄<br>
                            Dapatkan pengalaman kecantikan terbaikmu!
                        </p>
                    </div>

                    <div class="card-body">
                        <form class="form" data-parsley-validate action="../functions/cek_login.php" method="post" autocomplete="off">
                            <div class="form-group position-relative has-icon-left mb-3">
                                <label for="nama_user" class="form-label">Nama Lengkap</label>
                                <div class="position-relative">
                                    <input type="text" name="nama_user" class="form-control form-control-xl"
                                        placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($nama_userLogin); ?>" id="nama_user" required minlength="3">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group position-relative has-icon-left mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="position-relative">
                                    <input type="text" name="username" class="form-control form-control-xl"
                                        placeholder="Buat username unik" value="<?= htmlspecialchars($usernameLogin); ?>" id="username" required minlength="3">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group position-relative has-icon-left mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control form-control-xl"
                                        placeholder="Kata sandi minimal 5 karakter" id="password" required minlength="5">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group position-relative has-icon-left mb-3">
                                <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                <div class="position-relative">
                                    <input type="password" name="konfirmasi_password" class="form-control form-control-xl"
                                        placeholder="Ulangi kata sandi" id="konfirmasi_password" required minlength="5">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="role" value="klien">

                            <button type="submit" name="btn_register" class="btn btn-danger btn-block btn-lg shadow-lg mt-3 w-100">
                                <i class="bi bi-person-plus"></i> Daftar Sekarang
                            </button>
                        </form>

                        <div class="text-center mt-4 text-lg fs-5">
                            <p class="text-gray-600">
                                Sudah punya akun?
                                <a href="login" class="font-bold text-danger">Masuk di sini</a>.
                            </p>
                        </div>
                        <!-- <div class="text-center mt-2">
                            <a href="../index" class="text-muted small">
                                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../dashboard/assets/extensions/jquery/jquery.min.js"></script>
    <script src="../dashboard/assets/extensions/parsleyjs/parsley.min.js"></script>
    <script src="../dashboard/assets/static/js/pages/parsley.js"></script>
    <script src="../dashboard/assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get("status");
        const action = urlParams.get("action");

        if (status === "warning" && action === "userexist") {
            Swal.fire({
                icon: "warning",
                title: "Username sudah digunakan!",
                text: "Silakan gunakan username lain 💋",
                timer: 3000,
                showConfirmButton: false,
            });
        } else if (status === "warning" && action === "passwordnotsame") {
            Swal.fire({
                icon: "warning",
                title: "Password tidak sama!",
                text: "Pastikan kedua password cocok, ya 💕",
                timer: 3000,
                showConfirmButton: false,
            });
        } else if (status === "success" && action === "registered") {
            Swal.fire({
                icon: "success",
                title: "Akun Berhasil Dibuat!",
                text: "Selamat datang di Makeup Artist Yola 💄 Silakan login untuk mulai booking.",
                timer: 3000,
                showConfirmButton: false,
            });
        }
    </script>
</body>

</html>