<?php
// Hanya admin yang boleh mengakses
if ($_SESSION['sesi_role'] !== 'admin') {
    return;
}

include '../functions/koneksi.php';
?>

<section class="section table">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Riwayat Booking Makeup Artist (Selesai)
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="example2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Klien</th>
                            <th>Layanan</th>
                            <th>Tanggal Booking</th>
                            <th>Waktu Booking</th>
                            <th>Lokasi</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "
                            SELECT 
                                b.id_booking, 
                                u.nama_user AS nama_klien, 
                                s.nama_service, 
                                b.tanggal_booking, 
                                b.waktu_booking,
                                b.lokasi,
                                b.total_harga, 
                                b.status, 
                                b.catatan_klien
                            FROM bookings b
                            JOIN users u ON b.id_user = u.id_user
                            JOIN services s ON b.id_service = s.id_service
                            WHERE b.status = 'selesai'
                            ORDER BY b.id_booking DESC
                        ";
                        $sql = mysqli_query($koneksi, $query);

                        while ($booking = mysqli_fetch_assoc($sql)) :
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($booking['nama_klien']); ?></td>
                                <td><?= htmlspecialchars($booking['nama_service']); ?></td>
                                <td><?= htmlspecialchars($booking['tanggal_booking']); ?></td>
                                <td><?= htmlspecialchars($booking['waktu_booking']); ?></td>
                                <td><?= htmlspecialchars($booking['lokasi']); ?></td>
                                <td>Rp<?= number_format($booking['total_harga'], 0, ',', '.'); ?></td>
                                <td><span class="badge bg-success text-capitalize"><?= htmlspecialchars($booking['status']); ?></span></td>
                                <td><?= htmlspecialchars($booking['catatan_klien']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>