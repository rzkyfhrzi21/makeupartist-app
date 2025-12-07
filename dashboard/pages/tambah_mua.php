<?php
if ($_SESSION['sesi_role'] !== 'admin') {
    return;
}

// Ambil data lama dari session (jika validasi gagal)
$nama_service        = $_SESSION['form_service']['nama_service'] ?? '';
$deskripsi_singkat   = $_SESSION['form_service']['deskripsi_singkat'] ?? '';
$deskripsi_lengkap   = $_SESSION['form_service']['deskripsi_lengkap'] ?? '';
$harga_mulai         = $_SESSION['form_service']['harga_mulai'] ?? '';
$estimasi_durasi     = $_SESSION['form_service']['estimasi_durasi'] ?? '';

// Hapus setelah diambil
unset($_SESSION['form_service']);
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Layanan Makeup</h3>
                <p class="text-subtitle text-muted">
                    Tambahkan paket layanan baru untuk Makeup Artist Yola.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                        <li class="breadcrumb-item active text-capitalize" aria-current="page">
                            <?= htmlspecialchars($page); ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- FORM TAMBAH LAYANAN -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Informasi Layanan</h4>
                    </div>

                    <form action="../functions/function_mua.php" method="post" enctype="multipart/form-data" class="form">
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Layanan -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="nama_service" class="form-label">Nama Layanan</label>
                                        <input type="text" id="nama_service" class="form-control"
                                            name="nama_service"
                                            placeholder="Contoh: Makeup Pesta, Wisuda, Wedding"
                                            minlength="3"
                                            value="<?= htmlspecialchars($nama_service); ?>"
                                            required />
                                    </div>
                                </div>

                                <!-- Harga Mulai -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="harga_mulai" class="form-label">Harga Mulai (Rp)</label>
                                        <input type="number" id="harga_mulai" class="form-control"
                                            name="harga_mulai"
                                            placeholder="Contoh: 250000"
                                            value="<?= htmlspecialchars($harga_mulai); ?>"
                                            required />
                                    </div>
                                </div>

                                <!-- Estimasi Durasi -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="estimasi_durasi" class="form-label">Estimasi Durasi</label>
                                        <input type="text" id="estimasi_durasi" class="form-control"
                                            name="estimasi_durasi"
                                            placeholder="Contoh: 1,5 jam"
                                            value="<?= htmlspecialchars($estimasi_durasi); ?>" />
                                    </div>
                                </div>

                                <!-- Deskripsi Singkat -->
                                <div class="col-12">
                                    <div class="form-group mandatory">
                                        <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                                        <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="2"
                                            class="form-control"
                                            placeholder="Deskripsi singkat paket layanan"
                                            required><?= htmlspecialchars($deskripsi_singkat); ?></textarea>
                                    </div>
                                </div>

                                <!-- Deskripsi Lengkap -->
                                <div class="col-12">
                                    <div class="form-group mandatory">
                                        <label for="deskripsi_lengkap" class="form-label">Deskripsi Lengkap</label>
                                        <textarea id="deskripsi_lengkap" name="deskripsi_lengkap" rows="4"
                                            class="form-control"
                                            placeholder="Deskripsi lebih detail tentang layanan"><?= htmlspecialchars($deskripsi_lengkap); ?></textarea>
                                    </div>
                                </div>

                                <!-- Upload Foto Galeri -->
                                <div class="col-12 mt-3">
                                    <div class="form-group mandatory">
                                        <label for="gambar" class="form-label">Upload Foto Layanan (minimal 1)</label>
                                        <input type="file" id="gambar" name="gambar[]" class="form-control" accept=".jpg,.jpeg,.png,.webp"
                                            multiple required />
                                        <small class="text-muted">
                                            Anda dapat mengunggah hingga <b>5 gambar</b> (maks 1MB per file).
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" name="btn_tambahlayanan" class="btn btn-primary me-2">
                                        <i class="bi bi-plus-circle"></i> Tambah Layanan
                                    </button>
                                    <button type="reset" class="btn btn-light-secondary">
                                        Reset
                                    </button>
                                </div>
                            </div>
                            <!-- /Tombol -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>