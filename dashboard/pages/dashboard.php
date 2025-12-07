<div class="page-heading">
    <h3>Dashboard Mua Yola</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">

            <!-- ROW 1 : STATISTIK BOOKING -->
            <div class="row">
                <!-- Booking Hari Ini -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldCalendar"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Booking Hari Ini</h6>
                                    <h6 class="font-extrabold mb-0"><?= $bookingHariIni; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Minggu Ini -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldTime-Circle"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Booking Minggu Ini</h6>
                                    <h6 class="font-extrabold mb-0"><?= $bookingMingguIni; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Bulan Ini -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldDocument"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Booking Bulan Ini</h6>
                                    <h6 class="font-extrabold mb-0"><?= $bookingBulanIni; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Booking -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <span class="fa-fw select-all fas text-white">&#xf02d;</span>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Booking</h6>
                                    <h6 class="font-extrabold mb-0"><?= $bookingTotal; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 2 : STATISTIK PENDAPATAN -->
            <div class="row">
                <!-- Pendapatan Hari Ini -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pendapatan Hari Ini</h6>
                                    <h6 class="font-extrabold mb-0">
                                        Rp <?= number_format($pendapatanHariIni, 0, ',', '.'); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Minggu Ini -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pendapatan Minggu Ini</h6>
                                    <h6 class="font-extrabold mb-0">
                                        Rp <?= number_format($pendapatanMingguIni, 0, ',', '.'); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Bulan Ini -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pendapatan Bulan Ini</h6>
                                    <h6 class="font-extrabold mb-0">
                                        Rp <?= number_format($pendapatanBulanIni, 0, ',', '.'); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Total -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldWallet"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pendapatan Total</h6>
                                    <h6 class="font-extrabold mb-0">
                                        Rp <?= number_format($pendapatanTotal, 0, ',', '.'); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 3 : CHARTS -->
            <div class="row">
                <!-- Chart Booking per Status -->
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Booking MUA</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-booking-status"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Booking per Service -->
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah Booking per Paket MUA</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-service-bookings"></div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <!-- SIDEBAR KANAN -->
        <div class="col-12 col-lg-3">
            <!-- Profil Admin -->
            <div class="card">
                <div class="card-body py-3 px-4 pb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg">
                            <img src="assets/static/images/faces/1.jpg" alt="avatar">
                            <div class="ms-3 name">
                                <h5 class="font-bold"><?= $sesi_nama; ?></h5>
                                <h6 class="text-muted mb-0">@<?= $sesi_username; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Klien Baru Terakhir -->
            <div class="card">
                <div class="card-header">
                    <h4>Klien Baru Terakhir</h4>
                </div>
                <div class="card-content pb-4">
                    <?php
                    // ambil 3 klien terbaru
                    $queryUsers  = "SELECT * FROM users WHERE role = 'klien' ORDER BY id_user DESC LIMIT 3";
                    $sql_users   = mysqli_query($koneksi, $queryUsers);

                    while ($users = mysqli_fetch_array($sql_users)) :
                    ?>
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="assets/static/images/faces/1.jpg"
                                    onerror="this.src='assets/static/images/faces/1.jpg'" alt="avatar">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1"><?= htmlspecialchars($users['nama_user'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                <h6 class="text-muted mb-0">@<?= htmlspecialchars($users['username'], ENT_QUOTES, 'UTF-8'); ?></h6>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <div class="px-4">
                        <a href="?page=users" class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>
                            Lihat Semua Klien
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Ringkas -->
            <div class="card">
                <div class="card-header">
                    <h4>Ringkasan Data</h4>
                </div>
                <div class="card-body">
                    <p class="mb-2">Total Klien: <strong><?= $totalKlien; ?></strong></p>
                    <p class="mb-2">Total Paket MUA: <strong><?= $totalLayanan; ?></strong></p>
                </div>
            </div>
        </div>
    </section>
</div>