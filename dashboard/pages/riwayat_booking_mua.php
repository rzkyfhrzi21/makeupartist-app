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
                Riwayat Booking Makeup Artist (Belum Selesai)
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="example1">
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
                            <th class="text-center">Aksi</th>
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
                            WHERE b.status IN ('pending', 'dikonfirmasi')
                            ORDER BY b.id_booking DESC
                        ";
                        $sql = mysqli_query($koneksi, $query);

                        while ($booking = mysqli_fetch_assoc($sql)) :
                            switch (strtolower($booking['status'])) {
                                case 'pending':
                                    $badge = 'bg-warning';
                                    break;
                                case 'dikonfirmasi':
                                    $badge = 'bg-primary';
                                    break;
                                default:
                                    $badge = 'bg-secondary';
                                    break;
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($booking['nama_klien']); ?></td>
                                <td><?= htmlspecialchars($booking['nama_service']); ?></td>
                                <td><?= htmlspecialchars($booking['tanggal_booking']); ?></td>
                                <td><?= htmlspecialchars($booking['waktu_booking']); ?></td>
                                <td><?= htmlspecialchars($booking['lokasi']); ?></td>
                                <td>Rp<?= number_format($booking['total_harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge <?= $badge; ?> text-capitalize">
                                        <?= htmlspecialchars($booking['status']); ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($booking['catatan_klien']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pilih
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php if ($booking['status'] == 'pending') : ?>
                                                <form action="../functions/function_booking.php" method="post" class="m-0">
                                                    <input type="hidden" name="id_booking" value="<?= $booking['id_booking']; ?>">
                                                    <input type="hidden" name="status" value="dikonfirmasi">
                                                    <button type="submit" name="btn_updatestatus" class="dropdown-item text-success">
                                                        Konfirmasi Booking
                                                    </button>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                            <?php elseif ($booking['status'] == 'dikonfirmasi') : ?>
                                                <form action="../functions/function_booking.php" method="post" class="m-0">
                                                    <input type="hidden" name="id_booking" value="<?= $booking['id_booking']; ?>">
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" name="btn_updatestatus" class="dropdown-item text-primary">
                                                        Tandai Selesai
                                                    </button>
                                                </form>
                                                <div class="dropdown-divider"></div>
                                            <?php endif; ?>

                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalhapus<?= $booking['id_booking']; ?>">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- MODAL HAPUS -->
                            <div class="modal fade" id="modalhapus<?= $booking['id_booking']; ?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <form action="../functions/function_booking.php" method="post">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Hapus Riwayat Booking</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Apakah Anda yakin ingin menghapus booking
                                                    <b><?= htmlspecialchars($booking['nama_service']); ?></b>
                                                    milik <b><?= htmlspecialchars($booking['nama_klien']); ?></b>?
                                                </p>
                                            </div>
                                            <input type="hidden" name="id_booking" value="<?= $booking['id_booking']; ?>">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" name="btn_hapusbooking" class="btn btn-danger">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>