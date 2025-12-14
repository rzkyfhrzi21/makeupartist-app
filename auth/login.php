<?php
session_start();
if (@$_SESSION['sesi_role']) {
    switch ($_SESSION['sesi_role']) {
        case 'admin':
            header('Location: ../dashboard/admin');
            break;
        case 'klien':
            header('Location: ../dashboard/klien');
            break;
        default:
            header('Location: ../auth/logout.php');
            break;
    }
}

$usernameLogin = isset($_GET['username']) ? $_GET['username'] : '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title>Login - Makeup Artist Yola</title>

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
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 400px;
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

        p,
        label {
            font-size: 15px;
        }

        .text-danger {
            color: #d63384 !important;
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
                        <h2 class="auth-title">Login Akun MUA Yola</h2>
                        <p class="auth-subtitle text-muted mb-2">
                            Selamat datang di layanan Makeup Artist <b>Yola</b> 💋<br>
                            Wujudkan penampilan terbaikmu bersama kami!
                        </p>
                    </div>
                    <div class="card-body">
                        <form class="form" data-parsley-validate action="../functions/cek_login.php" method="post" autocomplete="off">
                            <div class="form-group position-relative has-icon-left mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="position-relative">
                                    <input type="text" name="username" class="form-control form-control-xl"
                                        placeholder="Masukkan username" value="<?= $usernameLogin; ?>" id="username" required minlength="3">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control form-control-xl"
                                        placeholder="Kata sandi kamu" id="password" required minlength="5">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                            </div>

                            <button name="btn_login" type="submit"
                                class="btn btn-danger btn-block btn-lg shadow-lg mt-3 w-100">
                                Masuk Sekarang
                            </button>
                        </form>
                        <div class="text-center mt-4 text-lg fs-5">
                            <p class="text-gray-600">Belum punya akun?
                                <a href="register" class="font-bold text-danger">Daftar Sekarang</a>
                            </p>
                        </div>
                        <!-- <div class="text-center mt-2">
                            <a href="../index" class="text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
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

        if (status === "success") {
            if (action === "registered") {
                Swal.fire({
                    icon: "success",
                    title: "Akun Berhasil Dibuat!",
                    text: "Selamat datang di Makeup Artist Yola 💄 Silakan login untuk mulai booking.",
                    timer: 3000,
                    showConfirmButton: false,
                });
            } else if (action === "deleteuser") {
                Swal.fire({
                    icon: "success",
                    title: "Akun Dihapus!",
                    text: "Akun Anda telah berhasil dihapus. Kami tunggu kedatangan Anda kembali 💕",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }
        } else if (status === "error") {
            if (action === "login") {
                Swal.fire({
                    icon: "error",
                    title: "Login Gagal!",
                    text: "Username atau password salah. Coba lagi ya 💋",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }
        }
    </script>
</body>

</html>