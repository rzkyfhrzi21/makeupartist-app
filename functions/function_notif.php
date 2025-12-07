<?php

// =====================================
// 📧 FUNCTION_NOTIF.PHP - Donorku System (Email Version)
// =====================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Jika belum instal PHPMailer lewat Composer, pastikan file berikut ada
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

// Header untuk API response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Ambil data dari GET/POST
$email_user       = $_REQUEST['email_user'] ?? '';
$kode_pesan       = $_REQUEST['kode_pesan'] ?? '';
$nama_user        = $_REQUEST['nama_user'] ?? '';
$tanggal_kegiatan = $_REQUEST['tanggal_kegiatan'] ?? '';

// Validasi dasar
if (empty($email_user) || $kode_pesan === '' || $tanggal_kegiatan === '' || empty($nama_user)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap",
        "debug" => [
            "email_user" => $email_user,
            "kode_pesan" => $kode_pesan,
            "nama_user" => $nama_user,
            "tanggal_kegiatan" => $tanggal_kegiatan
        ]
    ]);
    exit;
}

// LINK EMAIL DEBUGGING ==> 
// http://localhost/app-donor/functions/function_notif.php?email_user=rizky01011991@gmail.com&kode_pesan=0&nama_user=Rizky%20Fahrezi&tanggal_kegiatan=2025-08-08

// ==========================
// 💬 Format pesan per kode
// ==========================
switch ($kode_pesan) {
    case '0':
        // ❌ Tidak lolos saat pendaftaran awal
        $subject = "Hasil Pendaftaran Donor Darah - Belum Memenuhi Syarat";
        $body = "
        <p>Halo <b>{$nama_user}</b>,</p>
        <p>Terima kasih telah mendaftar sebagai pendonor darah untuk kegiatan pada tanggal <b>{$tanggal_kegiatan}</b>.</p>
        <p>Namun, berdasarkan data yang Anda isi, Anda <b>belum memenuhi syarat</b> untuk melakukan donor darah kali ini.</p>
        <p>Jangan berkecil hati — tetap jaga kesehatan dan semangat untuk membantu sesama di kesempatan berikutnya ❤️</p>
        <br>
        <p><b>Detail Kegiatan:</b><br>
        📅 <b>Tanggal:</b> {$tanggal_kegiatan}<br>
        📍 <b>Penyelenggara:</b> KSR PMI Unit Darmajaya</p>
        <br>
        <p>Salam hangat,<br><b>KSR PMI Unit Darmajaya</b><br>Donorku 2025</p>";
        break;

    case '1':
        // ✅ Berhasil donor darah dan lolos semua pemeriksaan
        $subject = "Terima Kasih Telah Donor Darah";
        $body = "
        <p>Halo <b>{$nama_user}</b>! 👋</p>
        <p>Terima kasih telah berpartisipasi dalam kegiatan <b>donor darah</b> pada tanggal <b>{$tanggal_kegiatan}</b>.</p>
        <p>Setetes darah Anda sangat berarti bagi mereka yang membutuhkan.</p>
        <p>Semoga selalu diberikan kesehatan, keberkahan, dan semangat untuk terus berbagi kebaikan ❤️</p>
        <br>
        <p><b>Detail Kegiatan:</b><br>
        📅 <b>Tanggal:</b> {$tanggal_kegiatan}<br>
        📍 <b>Penyelenggara:</b> KSR PMI Unit Darmajaya</p>
        <br>
        <p>Salam hangat,<br><b>KSR PMI Unit Darmajaya</b><br>Donorku 2025</p>";
        break;

    case '2':
        // ⚠️ Tidak lolos pemeriksaan kesehatan (setelah lolos daftar)
        $subject = "Hasil Pemeriksaan Kesehatan Donor Darah";
        $body = "
        <p>Halo <b>{$nama_user}</b>,</p>
        <p>Terima kasih telah hadir dalam kegiatan <b>donor darah</b> pada tanggal <b>{$tanggal_kegiatan}</b>.</p>
        <p>Namun, hasil pemeriksaan menunjukkan bahwa Anda <b>belum dapat melanjutkan proses donor</b> kali ini.</p>
        <p>Jaga pola makan, cukup istirahat, dan tetap semangat agar bisa berpartisipasi di kegiatan donor berikutnya 🩸</p>
        <br>
        <p><b>Detail Kegiatan:</b><br>
        📅 <b>Tanggal:</b> {$tanggal_kegiatan}<br>
        📍 <b>Penyelenggara:</b> KSR PMI Unit Darmajaya</p>
        <br>
        <p>Salam hangat,<br><b>KSR PMI Unit Darmajaya</b><br>Donorku 2025</p>";
        break;

    default:
        $subject = "Pesan Otomatis - Donorku System";
        $body = "
        <p>Halo <b>{$nama_user}</b>,</p>
        <p>Ini adalah pesan otomatis dari sistem Donorku.</p>
        <p>Kegiatan terkait tanggal: <b>{$tanggal_kegiatan}</b>.</p>";
        break;
}


// ==========================
// ✉️ Kirim Email via SMTP
// ==========================
$mail = new PHPMailer(true);
try {
    // Konfigurasi SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'fauziahzahra2002@gmail.com'; // ✅ email pengirim
    $mail->Password   = 'yzlg lifj opcg hrpr';        // 🔑 App Password Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Pengirim dan penerima
    $mail->setFrom('fauziahzahra2002@gmail.com', 'Donorku - KSR PMI Darmajaya');
    $mail->addAddress($email_user, $nama_user);

    // Konten email
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    // Kirim
    $mail->send();
    $status  = "success";
    $message = "Email berhasil dikirim ke {$email_user}";
} catch (Exception $e) {
    $status  = "error";
    $message = "Email gagal dikirim. Error: {$mail->ErrorInfo}";
}

// ==========================
// 📦 Output JSON
// ==========================
echo json_encode([
    "status"            => $status,
    "message"           => $message,
    "email_tujuan"      => $email_user,
    "subject"           => $subject,
    "kode_pesan"        => $kode_pesan,
    "tanggal_kegiatan"  => $tanggal_kegiatan
], JSON_PRETTY_PRINT);
