<?php
header('Content-Type: application/json');

include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($query) > 0) {

        $mail = new PHPMailer(true);

        try {
            // Konfigurasi SMTP Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'abiyyuilyasa60@gmail.com';
            $mail->Password = 'viwxdggvdjqdnetg';   // App Password 16 digit kamu
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Pengirim & Penerima
            $mail->setFrom('email-kamu@gmail.com', 'Flowers.co Support');
            $mail->addAddress($email);

            // Konten Email (Magic Link)
            $mail->isHTML(true);
            $mail->Subject = 'Magic Link Akses Flowers.co';
            $mail->Body = "
                <div style='font-family: sans-serif; padding: 20px; border: 1px solid #eee;'>
                    <h2 style='color: #d63384;'>Flowers.co</h2>
                    <p>Halo,</p>
                    <p>Kami menerima permintaan akses untuk akun Anda. Klik tombol di bawah ini untuk masuk secara otomatis tanpa password:</p>
                    <a href='http://localhost/FlowersWeb/verify.php?email=$email' 
                       style='display: inline-block; padding: 10px 20px; background-color: #d63384; color: white; text-decoration: none; border-radius: 5px;'>
                       Masuk ke Akun Saya
                    </a>
                    <p style='font-size: 12px; color: #777; margin-top: 20px;'>Link ini akan kedaluwarsa dalam 15 menit.</p>
                </div>
            ";

            $mail->send();

            echo json_encode(['success' => true]);

        } catch (Exception $e) {
            // Jika PHPMailer gagal
            echo json_encode([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $mail->ErrorInfo
            ]);
        }

    } else {
        // Jika email tidak ada di database
        echo json_encode([
            'success' => false,
            'message' => 'Maaf, email tidak terdaftar dalam sistem kami.'
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Akses ditolak.']);
}