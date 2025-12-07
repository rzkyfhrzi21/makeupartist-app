<?php
include '../functions/koneksi.php';

$id_user = htmlspecialchars($_SESSION['sesi_id']);
$query = "SELECT * FROM users WHERE id_user = '$id_user'";
$sql = mysqli_query($koneksi, $query);

if ($sql && mysqli_num_rows($sql) > 0) {
    $user = mysqli_fetch_assoc($sql);

    $nama_user = $user['nama_user'];
    $username  = $user['username'];
    $email     = $user['email'];
    $no_telp   = $user['no_telp'] ?? '';
    $alamat    = $user['alamat'] ?? '';
    $role      = $user['role'];
}
?>

<div class="page-heading">
    <h3>Profil Saya</h3>
    <p class="text-muted">Perbarui informasi akun Anda dengan benar ✨</p>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mb-3">
                        <img src="assets/static/images/faces/1.jpg" alt="Foto Profil" class="rounded-circle">
                    </div>
                    <h4><?= htmlspecialchars($nama_user); ?></h4>
                    <p class="text-muted">@<?= htmlspecialchars($username); ?></p>
                    <p class="text-sm text-capitalize"><?= htmlspecialchars($role); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="text-danger">Hapus Akun</h5>
                </div>
                <div class="card-body">
                    <form action="../functions/function_klien.php" method="post">
                        <p class="text-muted">Akun Anda akan dihapus permanen dan tidak dapat dipulihkan.</p>
                        <div class="form-check mb-3">
                            <input type="checkbox" id="agreeDelete" class="form-check-input">
                            <label for="agreeDelete">Saya yakin ingin menghapus akun ini.</label>
                        </div>
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user); ?>">
                        <div class="text-end">
                            <button type="submit" name="btn_deleteakun" id="btnDeleteAccount" class="btn btn-danger" disabled>Hapus Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <form action="../functions/function_admin.php" method="post" data-parsley-validate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_user" class="form-control" value="<?= htmlspecialchars($nama_user); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>No. Telepon</label>
                                <input type="tel" name="no_telp" class="form-control" pattern="^\d{10,15}$" value="<?= htmlspecialchars($no_telp); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($alamat); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" minlength="5" value="<?= htmlspecialchars($username); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" minlength="5" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" class="form-control" minlength="5" placeholder="Ulangi password baru">
                            </div>
                        </div>
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user); ?>">
                        <input type="hidden" name="role" value="<?= htmlspecialchars($role); ?>">
                        <input type="hidden" name="username_lama" value="<?= htmlspecialchars($username); ?>">
                        <div class="text-end">
                            <button type="submit" name="btn_editdataakun" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('agreeDelete').addEventListener('change', function() {
        document.getElementById('btnDeleteAccount').disabled = !this.checked;
    });
</script>