<?php
if ($_SESSION['sesi_role'] !== 'admin') {
    return;
}

$id_service = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id_service <= 0) {
    header('Location: admin.php?page=list mua');
    exit();
}

$query = "SELECT * FROM services WHERE id_service = '$id_service'";
$sql   = mysqli_query($koneksi, $query);

if ($sql && mysqli_num_rows($sql) > 0) {
    $service = mysqli_fetch_array($sql);
    $nama_service      = $service['nama_service'];
    $deskripsi_singkat = $service['deskripsi_singkat'];
    $deskripsi_lengkap = $service['deskripsi_lengkap'];
    $harga_mulai       = $service['harga_mulai'];
    $estimasi_durasi   = $service['estimasi_durasi'];
} else {
    die('Layanan tidak ditemukan.');
}
?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Paket Makeup</h3>
                <p class="text-subtitle text-muted">
                    Kelola informasi detail paket makeup artis kamu.
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

    <!-- INFORMASI LAYANAN -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Informasi Paket</h4>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?= $id_service; ?>">
                            Hapus Paket
                        </button>
                    </div>

                    <!-- Modal Hapus -->
                    <div class="modal fade text-left" id="modal-delete<?= $id_service; ?>" tabindex="-1" aria-labelledby="modalDeleteLabel<?= $id_service; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <form action="../functions/function_mua.php" method="post">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Paket</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus paket <b><?= htmlspecialchars($nama_service); ?></b> ini?</p>
                                    </div>
                                    <input type="hidden" name="id_service" value="<?= $id_service; ?>">
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="btn_deletelayanan" class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Modal Hapus -->

                    <form action="../functions/function_mua.php" method="post" enctype="multipart/form-data" class="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="nama_service" class="form-label">Nama Layanan</label>
                                        <input type="text" id="nama_service" class="form-control" name="nama_service"
                                            value="<?= htmlspecialchars($nama_service); ?>" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory">
                                        <label for="harga_mulai" class="form-label">Harga Mulai (Rp)</label>
                                        <input type="number" id="harga_mulai" class="form-control" name="harga_mulai"
                                            value="<?= htmlspecialchars($harga_mulai); ?>" required />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="estimasi_durasi" class="form-label">Estimasi Durasi</label>
                                        <input type="text" id="estimasi_durasi" class="form-control" name="estimasi_durasi"
                                            value="<?= htmlspecialchars($estimasi_durasi); ?>" placeholder="Ex. 1,5 Jam" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                                        <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="2" class="form-control"
                                            required><?= htmlspecialchars($deskripsi_singkat); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="deskripsi_lengkap" class="form-label">Deskripsi Lengkap</label>
                                        <textarea id="deskripsi_lengkap" name="deskripsi_lengkap" rows="4" class="form-control"><?= htmlspecialchars($deskripsi_lengkap); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="id_service" value="<?= $id_service; ?>">

                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" name="btn_editlayanan" class="btn btn-primary me-1 mb-1">
                                        Simpan Perubahan
                                    </button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /INFORMASI LAYANAN -->

    <!-- GALERI -->
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Galeri Makeup: <?= htmlspecialchars($nama_service); ?></h4>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-upload">
                    Upload Gambar
                </button>
            </div>

            <!-- Modal Upload -->
            <div class="modal fade text-left" id="modal-upload" tabindex="-1" aria-labelledby="modalUploadLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form action="../functions/function_mua.php" method="post" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalUploadLabel">Upload Gambar Galeri</h5>
                                <button type="button" class="close rounded-pill" data-bs-dismiss="modal">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="gambar" class="form-label">Foto</label>
                                    <input type="file"
                                        id="gambar"
                                        name="gambar[]"
                                        class="form-control"
                                        accept="image/*"
                                        multiple
                                        required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                                    <textarea id="deskripsi" name="deskripsi" rows="2" class="form-control" placeholder="Deskripsi singkat foto makeup"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="id_service" value="<?= $id_service; ?>">
                            <div class="modal-footer">
                                <button type="reset" class="btn" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="upload_imggaleri" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Modal Upload -->

            <div class="card-body">
                <div class="row gallery">
                    <?php
                    $qGaleri = "SELECT * FROM gallery WHERE id_service = '$id_service' ORDER BY created_at DESC";
                    $sqlGaleri = mysqli_query($koneksi, $qGaleri);

                    while ($galeri = mysqli_fetch_array($sqlGaleri)) :
                        $id_gallery = $galeri['id_gallery'];
                        $gambar     = $galeri['gambar'];
                        $deskripsi  = $galeri['deskripsi'];
                    ?>
                        <div class="col-6 col-sm-4 col-lg-3 mb-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal"
                                data-img="<?= htmlspecialchars($gambar); ?>"
                                data-id="<?= $id_gallery; ?>"
                                data-deskripsi="<?= htmlspecialchars($deskripsi); ?>">
                                <img class="w-100 rounded" src="assets/paket_mua/<?= htmlspecialchars($gambar); ?>" alt="Foto Makeup">
                            </a>
                            <?php if (!empty($deskripsi)) : ?>
                                <p class="small mt-1 text-center"><?= htmlspecialchars($deskripsi); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Preview -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="../functions/function_mua.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview Gambar</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="modalImage" class="d-block w-100 mb-2" src="" alt="Gambar Galeri">
                        <p id="modalDeskripsi"></p>
                    </div>
                    <input type="hidden" name="id_galerihapus" id="id_galerihapus">
                    <input type="hidden" name="gambar_hapus" id="gambar_hapus">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="btn_deleteimg" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const galleryImages = document.querySelectorAll('.gallery a');
            const modalImage = document.getElementById('modalImage');
            const modalDeskripsi = document.getElementById('modalDeskripsi');
            const idImageInput = document.getElementById('id_galerihapus');
            const imgHapusInput = document.getElementById('gambar_hapus');

            galleryImages.forEach(image => {
                image.addEventListener('click', function(e) {
                    e.preventDefault();
                    const img = this.getAttribute('data-img');
                    const id = this.getAttribute('data-id');
                    const deskripsi = this.getAttribute('data-deskripsi');

                    modalImage.src = "assets/paket_mua/" + img;
                    modalDeskripsi.textContent = deskripsi;
                    idImageInput.value = id;
                    imgHapusInput.value = img;
                });
            });
        });
    </script>
</div>