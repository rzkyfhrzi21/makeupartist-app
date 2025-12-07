<?php

if ($_SESSION['sesi_role'] !== 'admin') {
    return;
}

// Ambil data lama dari session jika sebelumnya gagal submit
$form_data = $_SESSION['form_data'] ?? [];
$nama_user  = $form_data['nama_user'] ?? '';
$email      = $form_data['email'] ?? '';
$username   = $form_data['username'] ?? '';
$role       = $form_data['role'] ?? 'klien';
$no_telp    = $form_data['no_telp'] ?? '';
$alamat     = $form_data['alamat'] ?? '';

// Hapus data session sementara
unset($_SESSION['form_data']);
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Registrasi User</h3>
                <p class="text-subtitle text-muted">
                    Tambah akun admin atau klien untuk sistem Makeup Artist.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active text-capitalize" aria-current="page">
                            <?= $page; ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!--  Basic Form -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <form action="../functions/function_admin.php" method="post" class="form" data-parsley-validate>
                        <!-- INFORMASI PRIBADI -->
                        <div class="card-header">
                            <h4 class="card-title">Informasi Pribadi</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">

                                    <!-- Nama Lengkap -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="nama_user" class="form-label">Nama Lengkap</label>
                                            <input type="text" id="nama_user" name="nama_user"
                                                class="form-control" minlength="3"
                                                value="<?= htmlspecialchars($nama_user); ?>"
                                                placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control"
                                                value="<?= htmlspecialchars($email); ?>"
                                                placeholder="Email aktif" required>
                                        </div>
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="no_telp" class="form-label">Nomor Telepon</label>
                                            <input type="tel" id="no_telp" name="no_telp"
                                                class="form-control" pattern="^\d{10,15}$"
                                                value="<?= htmlspecialchars($no_telp); ?>"
                                                placeholder="081234567890" required>
                                        </div>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                                            <input type="text" id="alamat" name="alamat"
                                                class="form-control"
                                                value="<?= htmlspecialchars($alamat); ?>"
                                                placeholder="Alamat lengkap" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- INFORMASI AKUN -->
                        <div class="card-header">
                            <h4 class="card-title">Informasi Akun</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">

                                    <!-- Username -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" id="username" name="username"
                                                class="form-control" minlength="5"
                                                value="<?= htmlspecialchars($username); ?>"
                                                placeholder="Username unik" required>
                                        </div>
                                    </div>

                                    <!-- Role -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="role" class="form-label">Role</label>
                                            <select name="role" id="role" class="form-select" required>
                                                <option value="admin" <?= $role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                <option value="klien" <?= $role === 'klien' ? 'selected' : ''; ?>>Klien</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" id="password" name="password"
                                                class="form-control" minlength="5"
                                                placeholder="Minimal 5 karakter" required>
                                        </div>
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mandatory">
                                            <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                            <input type="password" id="konfirmasi_password" name="konfirmasi_password"
                                                class="form-control" minlength="5"
                                                placeholder="Ulangi password" required>
                                        </div>
                                    </div>

                                </div>

                                <!-- Tombol Submit -->
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" name="btn_adminregister" class="btn btn-primary me-1 mb-1">
                                            <i class="bi bi-person-plus-fill me-1"></i> Registrasi
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                            Reset
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>