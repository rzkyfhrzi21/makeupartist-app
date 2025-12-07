<?php
if ($_SESSION['sesi_role'] !== 'admin') {
    return;
}

include '../functions/koneksi.php';
?>

<section class="section table">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Daftar Paket Makeup Artist (MUA)</h5>
            <a href="?page=tambah mua" class="btn btn-outline-primary btn-sm">+ Tambah Paket</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi Singkat</th>
                            <th>Harga Mulai</th>
                            <th>Durasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT * FROM services ORDER BY id_service DESC";
                        $sql_query = mysqli_query($koneksi, $query);

                        while ($service = mysqli_fetch_assoc($sql_query)) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($service['nama_service']); ?></td>
                                <td><?= htmlspecialchars($service['deskripsi_singkat']); ?></td>
                                <td>Rp<?= number_format($service['harga_mulai'], 0, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($service['estimasi_durasi']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pilih
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="?page=detail mua&id=<?= $service['id_service']; ?>">Detail</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="../functions/function_mua.php" method="post" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                                <input type="hidden" name="id_service" value="<?= $service['id_service']; ?>">
                                                <button type="submit" name="btn_deletelayanan" class="dropdown-item text-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>