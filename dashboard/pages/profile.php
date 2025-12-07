<?php
// Hanya admin yang boleh akses halaman ini
if ($_SESSION['sesi_role'] !== 'admin') {
    return;
}

$sesi_id       = $_SESSION['sesi_id'];
$sesi_username = $_SESSION['sesi_username'];
$sesi_nama     = $_SESSION['sesi_nama'];
$sesi_role     = $_SESSION['sesi_role'];

include '../functions/koneksi.php';

// Admin dapat melihat data user lain via ?id=, jika tidak gunakan id-nya sendiri
$id_user = !empty($_GET['id']) ? $_GET['id'] : $sesi_id;

// Ambil data user
$query = "SELECT * FROM users WHERE id_user = '$id_user'";
$sql   = mysqli_query($koneksi, $query);

if ($sql && mysqli_num_rows($sql) > 0) {
    $user = mysqli_fetch_assoc($sql);

    $id_user    = $user['id_user'];
    $nama_user  = $user['nama_user'];
    $email      = $user['email'];
    $username   = $user['username'];
    $role       = $user['role'];
    $no_telp    = $user['no_telp'] ?? '';
    $alamat     = $user['alamat'] ?? '';
} else {
    return;
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Profil Pengguna</h3>
                <p class="text-subtitle text-muted">Kelola informasi akun dengan hati-hati.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin">Dashboard</a></li>
                        <li class="breadcrumb-item active text-capitalize" aria-current="page"><?= htmlspecialchars($page); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- SIDEBAR PROFIL -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mb-3">
                        <img src="assets/static/images/faces/1.jpg" alt="Foto Profil" onerror="this.src='assets/static/images/faces/1.jpg'">
                    </div>
                    <h3 class="mt-2"><?= htmlspecialchars($nama_user); ?></h3>
                    <p class="text-capitalize text-muted"><?= htmlspecialchars($role); ?></p>
                    <p class="text-muted small mb-0">ID: <b><?= htmlspecialchars($id_user); ?></b></p>
                </div>
            </div>

            <!-- HAPUS AKUN -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-danger">Hapus Akun</h5>
                </div>
                <div class="card-body">
                    <form action="../functions/function_admin.php" method="post">
                        <p>Akun ini akan dihapus <b>secara permanen</b> dan tidak dapat dikembalikan.</p>
                        <div class="form-check mb-2">
                            <input type="checkbox" id="iagree" class="form-check-input">
                            <label for="iagree">Saya setuju untuk menghapus akun ini.</label>
                        </div>
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user); ?>">
                        <div class="text-end">
                            <button type="submit" name="btn_deleteakun" class="btn btn-danger" id="btn-delete-account" disabled>Hapus Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FORM INFORMASI AKUN -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informasi Akun</h5>
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
                                <input type="tel" name="no_telp" class="form-control" pattern="^\d{10,15}$" value="<?= htmlspecialchars($no_telp); ?>" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($alamat); ?>" placeholder="Alamat Lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" minlength="5" value="<?= htmlspecialchars($username); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="admin" <?= $role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                    <option value="klien" <?= $role === 'klien' ? 'selected' : ''; ?>>Klien</option>
                                </select>
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
                        <input type="hidden" name="username_lama" value="<?= htmlspecialchars($username); ?>">
                        <input type="hidden" name="sesi_username" value="<?= htmlspecialchars($sesi_username); ?>">
                        <div class="text-end">
                            <button type="submit" name="btn_editdataakun" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="../dashboard/admin" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cb = document.getElementById('iagree');
        const btn = document.getElementById('btn-delete-account');
        if (cb && btn) cb.addEventListener('change', () => btn.disabled = !cb.checked);
    });
</script>