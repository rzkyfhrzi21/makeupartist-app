<?php
// Pastikan user login sebagai klien
if ($_SESSION['sesi_role'] !== 'klien') {
    return;
}

include '../functions/koneksi.php';

$sesi_id   = $_SESSION['sesi_id'];
$sesi_nama = $_SESSION['sesi_nama'];
?>

<section class="section table">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Riwayat Booking Saya</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="example1">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:5%;">No</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "
                            SELECT 
                                b.id_booking, 
                                s.nama_service,
                                b.tanggal_booking, 
                                b.waktu_booking,
                                b.lokasi,
                                b.total_harga, 
                                b.status
                            FROM bookings b
                            JOIN services s ON b.id_service = s.id_service
                            WHERE b.id_user = '$sesi_id'
                            ORDER BY b.id_booking DESC
                        ";
                        $sql = mysqli_query($koneksi, $query);

                        if (mysqli_num_rows($sql) === 0) {
                            echo '<tr><td colspan="8" class="text-center text-muted">Belum ada riwayat booking.</td></tr>';
                        } else {
                            while ($booking = mysqli_fetch_assoc($sql)) {
                                $status = strtolower($booking['status']);
                                switch ($status) {
                                    case 'pending':
                                        $badge = 'bg-warning';
                                        break;
                                    case 'dikonfirmasi':
                                        $badge = 'bg-primary';
                                        break;
                                    case 'selesai':
                                        $badge = 'bg-success';
                                        break;
                                    default:
                                        $badge = 'bg-secondary';
                                        break;
                                }
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($booking['nama_service']); ?></td>
                                    <td><?= htmlspecialchars($booking['tanggal_booking']); ?></td>
                                    <td><?= htmlspecialchars($booking['waktu_booking']); ?></td>
                                    <td><?= htmlspecialchars($booking['lokasi']); ?></td>
                                    <td>Rp<?= number_format($booking['total_harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge <?= $badge; ?> text-uppercase px-3 py-2">
                                            <?= htmlspecialchars($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($status === 'dikonfirmasi') : ?>
                                            <form action="../functions/function_booking.php" method="post" class="d-inline">
                                                <input type="hidden" name="id_booking" value="<?= $booking['id_booking']; ?>">
                                                <button type="submit" name="btn_selesaikan"
                                                    class="btn btn-success btn-sm px-3 py-2 fw-semibold">
                                                    <i class="bi bi-check-circle me-1"></i> Selesai
                                                </button>
                                            </form>
                                        <?php elseif ($status === 'selesai') : ?>
                                            <span class="text-success fw-semibold">
                                                <i class="bi bi-check2-circle"></i> Selesai
                                            </span>
                                        <?php else : ?>
                                            <span class="text-muted">Menunggu</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>