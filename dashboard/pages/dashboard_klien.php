<div class="page-heading">
    <h3>Selamat datang, <?= htmlspecialchars($sesi_nama); ?> 💄✨</h3>
    <p class="text-muted">Siap tampil memukau bersama MUA Yola!</p>
</div>

<div class="page-content">
    <section class="row">
        <!-- KONTEN UTAMA -->
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4>Paket Makeup Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>Nama Layanan</th>
                                    <th>Harga Mulai</th>
                                    <th>Durasi</th>
                                    <th>Deskripsi Singkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../functions/koneksi.php';
                                $query = "SELECT * FROM services ORDER BY id_service DESC LIMIT 5";
                                $sql_query = mysqli_query($koneksi, $query);

                                if (mysqli_num_rows($sql_query) > 0) {
                                    while ($service = mysqli_fetch_assoc($sql_query)) :
                                ?>
                                        <tr>
                                            <td><?= htmlspecialchars($service['nama_service']); ?></td>
                                            <td>Rp<?= number_format($service['harga_mulai'], 0, ',', '.'); ?></td>
                                            <td><?= htmlspecialchars($service['estimasi_durasi']); ?></td>
                                            <td><?= htmlspecialchars($service['deskripsi_singkat']); ?></td>
                                        </tr>
                                <?php
                                    endwhile;
                                } else {
                                    echo '<tr><td colspan="4" class="text-center text-muted">Belum ada layanan tersedia.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="?page=list mua" class="btn btn-primary btn-sm">Lihat Semua Layanan</a>
                    </div>
                </div>
            </div>

            <!-- Booking Aktif -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Booking Aktif Saya</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $id_user = $sesi_id;
                                $query_booking = "
                                    SELECT b.*, s.nama_service 
                                    FROM bookings b
                                    JOIN services s ON b.id_service = s.id_service
                                    WHERE b.id_user = '$id_user'
                                    ORDER BY b.id_booking DESC LIMIT 3
                                ";
                                $sql_booking = mysqli_query($koneksi, $query_booking);

                                if (mysqli_num_rows($sql_booking) > 0) {
                                    while ($booking = mysqli_fetch_assoc($sql_booking)) {
                                        $badge = 'bg-secondary';
                                        switch ($booking['status']) {
                                            case 'pending':
                                                $badge = 'bg-warning';
                                                break;
                                            case 'dikonfirmasi':
                                                $badge = 'bg-primary';
                                                break;
                                            case 'selesai':
                                                $badge = 'bg-success';
                                                break;
                                        }
                                ?>
                                        <tr>
                                            <td><?= htmlspecialchars($booking['nama_service']); ?></td>
                                            <td><?= htmlspecialchars($booking['tanggal_booking']); ?></td>
                                            <td><?= htmlspecialchars($booking['waktu_booking']); ?></td>
                                            <td><?= htmlspecialchars($booking['lokasi']); ?></td>
                                            <td><span class="badge <?= $badge; ?> text-capitalize"><?= htmlspecialchars($booking['status']); ?></span></td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center text-muted">Belum ada booking aktif.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="?page=riwayat booking mua" class="btn btn-outline-primary btn-sm">Lihat Semua Riwayat</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SIDEBAR PROFIL -->
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body text-center py-4">
                    <div class="avatar avatar-xl mb-3">
                        <img src="assets/static/images/faces/1.jpg" alt="Foto Profil Default" class="rounded-circle">
                    </div>
                    <h5 class="font-bold mb-1"><?= htmlspecialchars($sesi_nama); ?></h5>
                    <p class="text-muted mb-0">@<?= htmlspecialchars($sesi_username); ?></p>
                    <p class="text-muted small"><?= htmlspecialchars($sesi_email); ?></p>
                    <a href="?page=profile" class="btn btn-outline-primary btn-sm mt-2">Lihat Profil</a>
                </div>
            </div>

            <!-- Info Sistem -->
            <div class="card mt-3">
                <div class="card-header">
                    <h4>Info MUA Yola</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Temukan MUA terbaik sesuai kebutuhanmu.
                        Jadwalkan makeup untuk acara spesialmu dengan mudah dan cepat 💅
                    </p>
                    <a href="?page=list mua" class="btn btn-primary btn-sm w-100 mt-2">Booking Sekarang</a>
                </div>
            </div>
        </div>
    </section>
</div>