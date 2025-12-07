<?php
// Pastikan hanya klien yang bisa mengakses
if ($_SESSION['sesi_role'] !== 'klien') {
    header('Location: ../auth/login');
    exit();
}

include '../functions/koneksi.php';

$id_service = htmlspecialchars(trim($_GET['id_service'] ?? ''));
if ($id_service === '') {
    echo '<div class="alert alert-danger">Paket MUA tidak ditemukan.</div>';
    exit();
}

// Ambil data paket MUA
$query_service = mysqli_query($koneksi, "SELECT * FROM services WHERE id_service = '$id_service'");
$service = mysqli_fetch_assoc($query_service);
if (!$service) {
    echo '<div class="alert alert-warning">Data paket MUA tidak tersedia.</div>';
    exit();
}

// Ambil data user dari session
$sesi_id   = $_SESSION['sesi_id'];
$sesi_nama = $_SESSION['sesi_nama'];
$tanggal_booking = date('Y-m-d');

// Ambil no_telp dari tabel users
$query_user = mysqli_query($koneksi, "SELECT no_telp FROM users WHERE id_user = '$sesi_id'");
$user = mysqli_fetch_assoc($query_user);
$no_telp = $user['no_telp'] ?? '-';
?>
<div class="page-heading mb-4">
    <h3>Booking MUA</h3>
    <p class="text-muted">Isi formulir di bawah untuk melakukan pemesanan layanan MUA 💄</p>
</div>

<form action="../functions/function_mua.php" method="post" class="form" enctype="multipart/form-data">
    <section id="booking-form">
        <div class="row">
            <!-- Kolom kiri: Informasi Paket -->
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Informasi Paket MUA</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <?php
                            $gambar_q = mysqli_query($koneksi, "SELECT gambar FROM gallery WHERE id_service = '$id_service' LIMIT 1");
                            $gambar = mysqli_fetch_assoc($gambar_q);
                            $gambar_path = $gambar && !empty($gambar['gambar'])
                                ? "assets/paket_mua/" . htmlspecialchars($gambar['gambar'])
                                : "assets/paket_mua/default.jpeg";
                            ?>
                            <img src="<?= $gambar_path; ?>" alt="Gambar Paket"
                                class="img-fluid rounded-3 shadow-sm"
                                style="max-height: 300px; object-fit: contain;"
                                onerror="this.src='assets/paket_mua/default.jpeg'">
                        </div>

                        <h5 class="text-danger"><?= htmlspecialchars($service['nama_service']); ?></h5>
                        <p class="text-muted mb-2"><?= htmlspecialchars($service['deskripsi_singkat']); ?></p>
                        <p><b>Durasi:</b> <?= htmlspecialchars($service['estimasi_durasi'] ?? '-'); ?></p>
                        <p><b>Harga Mulai:</b> Rp <?= number_format($service['harga_mulai'], 0, ',', '.'); ?></p>

                        <details class="mt-3">
                            <summary class="fw-semibold text-primary">Deskripsi Lengkap</summary>
                            <p class="mt-2"><?= nl2br(htmlspecialchars($service['deskripsi_lengkap'] ?? '-')); ?></p>
                        </details>
                    </div>
                </div>
            </div>

            <!-- Kolom kanan: Form Booking -->
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Pemesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- ID User (hidden) -->
                            <input type="hidden" name="id_user" value="<?= htmlspecialchars($sesi_id); ?>">

                            <!-- Nama & No Telp -->
                            <div class="col-md-6 mb-3">
                                <label for="nama_user" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama_user" class="form-control" readonly
                                    value="<?= htmlspecialchars($sesi_nama); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" id="no_telp" class="form-control" readonly
                                    value="<?= htmlspecialchars($no_telp); ?>">
                            </div>

                            <!-- Lokasi -->
                            <div class="col-md-12 mb-3">
                                <label for="lokasi" class="form-label">Lokasi Makeup</label>
                                <input type="text" id="lokasi" name="lokasi"
                                    class="form-control" placeholder="Contoh: Jl. Melati No. 12, Bandar Lampung" required>
                            </div>

                            <!-- Waktu Booking -->
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_booking" class="form-label">Tanggal Booking</label>
                                <input type="date" id="tanggal_booking" name="tanggal_booking"
                                    class="form-control" min="<?= $tanggal_booking; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktu_booking" class="form-label">Waktu Makeup</label>
                                <input type="time" id="waktu_booking" name="waktu_booking"
                                    class="form-control" required>
                            </div>

                            <!-- Total Harga -->
                            <div class="col-md-6 mb-3">
                                <label for="total_harga" class="form-label">Estimasi Harga (Rp)</label>
                                <input type="number" id="total_harga" name="total_harga"
                                    class="form-control" readonly
                                    value="<?= htmlspecialchars($service['harga_mulai']); ?>">
                            </div>

                            <!-- Catatan -->
                            <div class="col-md-12 mb-3">
                                <label for="catatan_klien" class="form-label">Catatan Tambahan</label>
                                <textarea id="catatan_klien" name="catatan_klien" class="form-control"
                                    rows="3" placeholder="Tambahkan catatan jika ada preferensi khusus (opsional)"></textarea>
                            </div>

                            <!-- Hidden Inputs -->
                            <input type="hidden" name="id_service" value="<?= htmlspecialchars($id_service); ?>">
                            <input type="hidden" name="status" value="pending">

                            <!-- Tombol Submit -->
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" name="btn_tambahbooking"
                                    class="btn btn-danger fw-semibold shadow-sm rounded-4 px-4 py-3
                                           w-100 w-md-auto fs-5 d-flex justify-content-center align-items-center gap-2">
                                    <span><i class="bi bi-calendar-check"></i> Konfirmasi Booking</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>