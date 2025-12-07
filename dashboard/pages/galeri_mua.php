<?php
if (empty($_SESSION['sesi_role'])) {
    return;
}

include '../functions/koneksi.php';
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Galeri Makeup Artist (Portofolio)</h3>
                <p class="text-subtitle text-muted">
                    Kumpulan hasil karya Makeup Artist Yola berdasarkan layanan yang tersedia.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active text-capitalize" aria-current="page">
                            <?= htmlspecialchars($page); ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- GALERI MUA -->
    <section class="section">
        <div class="row">
            <div class="col-12">
                <?php
                // Ambil galeri berdasarkan service
                $query = "
                    SELECT g.id_gallery, g.id_service, g.gambar, g.deskripsi, s.nama_service
                    FROM gallery g
                    JOIN services s ON g.id_service = s.id_service
                    ORDER BY s.id_service DESC, g.id_gallery DESC
                ";
                $result = mysqli_query($koneksi, $query);

                if (!$result) {
                    die('Query gagal: ' . mysqli_error($koneksi));
                }

                // Susun galeri per layanan
                $service_array = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_service = $row['id_service'];
                    $nama_service = $row['nama_service'];

                    if (!isset($service_array[$id_service])) {
                        $service_array[$id_service] = [
                            'nama_service' => $nama_service,
                            'images' => []
                        ];
                    }

                    $service_array[$id_service]['images'][] = [
                        'id_gallery' => $row['id_gallery'],
                        'gambar' => $row['gambar'],
                        'deskripsi' => $row['deskripsi']
                    ];
                }

                // Tampilkan setiap service dengan galeri-nya
                foreach ($service_array as $id_service => $data):
                ?>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title"><?= htmlspecialchars($data['nama_service']); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row gallery">
                                <?php if (!empty($data['images'])): ?>
                                    <?php foreach ($data['images'] as $img): ?>
                                        <div class="col-6 col-sm-6 col-lg-3 mb-3">
                                            <a href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#galleryModal"
                                                data-img_src="assets/paket_mua/<?= htmlspecialchars($img['gambar']); ?>"
                                                data-deskripsi="<?= htmlspecialchars($img['deskripsi']); ?>">
                                                <img class="w-100 rounded shadow-sm"
                                                    src="assets/paket_mua/<?= htmlspecialchars($img['gambar']); ?>"
                                                    alt="<?= htmlspecialchars($data['nama_service']); ?>">
                                            </a>
                                            <?php if (!empty($img['deskripsi'])): ?>
                                                <p class="mt-2 text-center small text-muted"><?= htmlspecialchars($img['deskripsi']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-center text-muted">Belum ada foto untuk layanan ini.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Modal Preview Gambar -->
    <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalTitle">Detail Gambar Makeup</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" class="img-fluid rounded shadow mb-3" src="" alt="Gambar Makeup">
                    <p id="modalDeskripsi" class="text-muted small"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Preview Handler
        document.addEventListener('DOMContentLoaded', function() {
            const galleryImages = document.querySelectorAll('.gallery a');
            const modalImage = document.getElementById('modalImage');
            const modalDeskripsi = document.getElementById('modalDeskripsi');

            galleryImages.forEach(image => {
                image.addEventListener('click', function() {
                    const imgSrc = this.getAttribute('data-img_src');
                    const deskripsi = this.getAttribute('data-deskripsi');

                    modalImage.src = imgSrc;
                    modalDeskripsi.textContent = deskripsi || '';
                });
            });
        });
    </script>
</div>