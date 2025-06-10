<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // kalau pakai Composer
// require 'PHPMailer/src/PHPMailer.php'; // kalau manual include
// require 'PHPMailer/src/SMTP.php';
// require 'PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = htmlspecialchars(trim($_POST['nama']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $pesan = htmlspecialchars(trim($_POST['pesan']));

    if ($nama && $email && $pesan) {
        $mail = new PHPMailer(true);

        try {
            // Konfigurasi SMTP Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'okmweb@gmail.com'; // Ganti ini
            $mail->Password   = '   ';      // App password Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Pengirim & Penerima
            $mail->setFrom('okmweb@gmail.com', 'Website okmweb');
            $mail->addAddress('okmweb@gmail.com', 'okmweb');

            // Konten Email
            $mail->isHTML(true);
            $mail->Subject = 'Pesan Baru dari Form Hubungi Kami';
            $mail->Body    = "
                <h3>Pesan dari $nama</h3>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Pesan:</strong><br>$pesan</p>
            ";

            $mail->send();
            echo "✅ Pesan berhasil dikirim!";
        } catch (Exception $e) {
            echo "❌ Gagal mengirim email. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "⚠️ Semua field wajib diisi.";
    }
}
?>
