<?php

include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');

$tanggal_sekarang   = date('Y-m-d');
$waktu_sekarang     = date('H:i');
$bulan_sekarang     = date('m');
$tahun_sekarang     = date('Y');

// Hitung awal & akhir minggu ini (Senin–Minggu)
$awal_minggu  = date('Y-m-d', strtotime('monday this week'));
$akhir_minggu = date('Y-m-d', strtotime('sunday this week'));

/* ==========================================================
   BOOKING / PEMESANAN
   ========================================================== */


$chartServiceLabels = []; // berisi nama_service
$chartServiceSeries = []; // berisi jumlah booking tiap service

// Contoh query:
$sqlServiceChart = mysqli_query($koneksi, "
    SELECT s.nama_service, COUNT(b.id_booking) AS total_booking
    FROM services s
    LEFT JOIN bookings b ON b.id_service = s.id_service
    GROUP BY s.id_service
    ORDER BY total_booking DESC
");

$chartServiceLabels = [];
$chartServiceSeries = [];

while ($row = mysqli_fetch_assoc($sqlServiceChart)) {
    $chartServiceLabels[] = $row['nama_service'];
    $chartServiceSeries[] = (int)$row['total_booking'];
}

function countBookingByStatus($koneksi, $status)
{
    $statusEscaped = mysqli_real_escape_string($koneksi, $status);
    $sql = mysqli_query($koneksi, "
        SELECT COUNT(*) AS jml 
        FROM bookings
        WHERE status = '$statusEscaped'
    ");
    $row = mysqli_fetch_assoc($sql);
    return (int)$row['jml'];
}

// TIGA status saja untuk chart
$totalBookingPending      = countBookingByStatus($koneksi, 'pending');
$totalBookingDikonfirmasi = countBookingByStatus($koneksi, 'dikonfirmasi');
$totalBookingSelesai      = countBookingByStatus($koneksi, 'selesai');


// Jumlah booking hari ini (berdasarkan tanggal_booking)
$sql_bookingHariIni = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS booking_hari_ini 
     FROM bookings 
     WHERE tanggal_booking = '$tanggal_sekarang'"
);
$bookingHariIni = mysqli_fetch_assoc($sql_bookingHariIni)['booking_hari_ini'];

// Jumlah booking minggu ini
$sql_bookingMingguIni = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS booking_minggu_ini 
     FROM bookings 
     WHERE tanggal_booking BETWEEN '$awal_minggu' AND '$akhir_minggu'"
);
$bookingMingguIni = mysqli_fetch_assoc($sql_bookingMingguIni)['booking_minggu_ini'];

// Jumlah booking bulan ini
$sql_bookingBulanIni = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS booking_bulan_ini 
     FROM bookings 
     WHERE MONTH(tanggal_booking) = '$bulan_sekarang'
       AND YEAR(tanggal_booking)  = '$tahun_sekarang'"
);
$bookingBulanIni = mysqli_fetch_assoc($sql_bookingBulanIni)['booking_bulan_ini'];

// Jumlah booking total (semua waktu)
$sql_bookingTotal = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS booking_total FROM bookings"
);
$bookingTotal = mysqli_fetch_assoc($sql_bookingTotal)['booking_total'];

/* ==========================================================
   PENDAPATAN (SUM total_harga)
   ========================================================== */

// Pendapatan hari ini
$sql_pendapatanHariIni = mysqli_query(
    $koneksi,
    "SELECT COALESCE(SUM(total_harga), 0) AS pendapatan_hari_ini 
     FROM bookings 
     WHERE tanggal_booking = '$tanggal_sekarang'"
);
$pendapatanHariIni = mysqli_fetch_assoc($sql_pendapatanHariIni)['pendapatan_hari_ini'];

// Pendapatan minggu ini
$sql_pendapatanMingguIni = mysqli_query(
    $koneksi,
    "SELECT COALESCE(SUM(total_harga), 0) AS pendapatan_minggu_ini 
     FROM bookings 
     WHERE tanggal_booking BETWEEN '$awal_minggu' AND '$akhir_minggu'"
);
$pendapatanMingguIni = mysqli_fetch_assoc($sql_pendapatanMingguIni)['pendapatan_minggu_ini'];

// Pendapatan bulan ini
$sql_pendapatanBulanIni = mysqli_query(
    $koneksi,
    "SELECT COALESCE(SUM(total_harga), 0) AS pendapatan_bulan_ini 
     FROM bookings 
     WHERE MONTH(tanggal_booking) = '$bulan_sekarang'
       AND YEAR(tanggal_booking)  = '$tahun_sekarang'"
);
$pendapatanBulanIni = mysqli_fetch_assoc($sql_pendapatanBulanIni)['pendapatan_bulan_ini'];

// Pendapatan total (semua waktu)
$sql_pendapatanTotal = mysqli_query(
    $koneksi,
    "SELECT COALESCE(SUM(total_harga), 0) AS pendapatan_total 
     FROM bookings"
);
$pendapatanTotal = mysqli_fetch_assoc($sql_pendapatanTotal)['pendapatan_total'];

/* ==========================================================
   DATA USER & LAYANAN
   ========================================================== */

// Total user dengan role = 'klien'
$sql_totalKlien = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total_klien 
     FROM users 
     WHERE role = 'klien'"
);
$totalKlien = mysqli_fetch_assoc($sql_totalKlien)['total_klien'];

// Total layanan paket makeup yang tersedia
$sql_totalLayanan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total_layanan 
     FROM services"
);
$totalLayanan = mysqli_fetch_assoc($sql_totalLayanan)['total_layanan'];
