<?php
// Pastikan user adalah klien
if ($_SESSION['sesi_role'] !== 'klien') {
    return;
}

include '../functions/koneksi.php';
?>

<section class="section">
    <div class="page-heading mb-4">
        <h3 class="fw-bold">Daftar Paket MUA</h3>
        <p class="text-muted fs-5">Temukan paket MUA terbaik sesuai kebutuhanmu 💄</p>
    </div>

    <div class="row">
        <?php
        // Ambil semua paket MUA dari tabel services
        $query_services = "SELECT * FROM services ORDER BY id_service DESC";
        $sql_services   = mysqli_query($koneksi, $query_services);

        if (mysqli_num_rows($sql_services) > 0) :
            while ($service = mysqli_fetch_assoc($sql_services)) :
                $id_service        = $service['id_service'];
                $nama_paket        = htmlspecialchars($service['nama_service']);
                $deskripsi_singkat = htmlspecialchars($service['deskripsi_singkat']);
                $deskripsi_lengkap = htmlspecialchars($service['deskripsi_lengkap']);
                $harga             = number_format($service['harga_mulai'], 0, ',', '.');
                $durasi            = htmlspecialchars($service['estimasi_durasi'] ?? '-');

                // Ambil maksimal 3 gambar dari gallery untuk setiap paket
                $query_gallery = "SELECT gambar FROM gallery WHERE id_service = '$id_service' LIMIT 3";
                $sql_gallery   = mysqli_query($koneksi, $query_gallery);

                // Jika tidak ada gambar, gunakan default
                $gambar_list = [];
                while ($g = mysqli_fetch_assoc($sql_gallery)) {
                    $gambar_list[] = "assets/paket_mua/" . htmlspecialchars($g['gambar']);
                }
                if (empty($gambar_list)) {
                    $gambar_list[] = "assets/paket_mua/default.jpeg";
                }
        ?>
                <div class="col-md-4 col-lg-4 mb-4">
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <!-- Judul Paket -->
                        <div class="card-header bg-white border-0 pb-0">
                            <h4 class="text-danger fw-bold mb-2"><?= $nama_paket; ?></h4>
                        </div>

                        <!-- Carousel Gambar -->
                        <div id="carouselService<?= $id_service; ?>" class="carousel slide mx-3 mt-2 rounded-3 overflow-hidden" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($gambar_list as $index => $foto) : ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                        <img src="<?= $foto; ?>"
                                            class="d-block w-100 rounded-3 img-fluid"
                                            alt="<?= $nama_paket; ?>"
                                            style="object-fit: scale-down; max-height: 500px;"
                                            onerror="this.src='assets/paket_mua/default.jpeg'">
                                    </div>

                                <?php endforeach; ?>
                            </div>
                            <?php if (count($gambar_list) > 1) : ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselService<?= $id_service; ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselService<?= $id_service; ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Isi Card -->
                        <div class="card-body px-4 pb-4 pt-3">
                            <p class="text-muted fs-6 mb-2"><?= nl2br($deskripsi_singkat); ?></p>
                            <?php if (!empty($deskripsi_lengkap)) : ?>
                                <p class="text-secondary mb-3" style="font-size: 15px; line-height: 1.6;">
                                    <?= nl2br($deskripsi_lengkap); ?>
                                </p>
                            <?php endif; ?>

                            <ul class="list-unstyled small mb-4 fs-6">
                                <li><i class="bi bi-clock me-2 text-danger"></i>Durasi: <b><?= $durasi; ?></b></li>
                                <li><i class="bi bi-cash-coin me-2 text-danger"></i>Mulai dari <b>Rp <?= $harga; ?></b></li>
                            </ul>

                            <div class="text-end mt-3">
                                <div class="text-end mt-3">
                                    <a href="?page=booking mua&id_service=<?= urlencode($id_service); ?>"
                                        class="btn btn-danger fw-semibold shadow-sm rounded-4 px-4 py-2
              w-100 w-md-auto fs-6 fs-md-5 d-flex justify-content-center align-items-center gap-2">
                                        <span><i class="bi bi-calendar-check"></i> Booking Sekarang</span>

                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            <?php
            endwhile;
        else :
            ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-circle"></i> Belum ada paket MUA yang tersedia saat ini.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>