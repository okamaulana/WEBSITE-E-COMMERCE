<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pesan = "";
if (isset($_SESSION['pesan_terkirim'])) {
    $pesan = $_SESSION['pesan_terkirim'];
    unset($_SESSION['pesan_terkirim']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['pesan_terkirim'] = "⚠️ Permintaan tidak valid.";
        header("Location: hubungi-kami.php");
        exit;
    }

    $nama = htmlspecialchars(trim($_POST['nama']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $pesan_input = htmlspecialchars(trim($_POST['pesan']));

    if ($nama && $email && $pesan_input) {
        $to = "okamaulana006@gmail.com";
        $subject = "Pesan Baru dari $nama";
        $message = "Nama: $nama\nEmail: $email\n\nPesan:\n$pesan_input";
        $headers = "From: noreply@okmweb.com\r\n";
        $headers .= "Reply-To: $email\r\n";

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['pesan_terkirim'] = "✅ Pesan berhasil dikirim ke email.";
        } else {
            $_SESSION['pesan_terkirim'] = "❌ Gagal mengirim email. Pastikan fungsi mail() aktif di server.";
        }
    } else {
        $_SESSION['pesan_terkirim'] = "⚠️ Semua kolom wajib diisi.";
    }

    header("Location: hubungi-kami.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hubungi Kami - OKMWEB</title>
    <link rel="icon" type="assets/png" href="assets/logol.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('assets/background.jpeg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            font-size: 15px;
        }

        .btn-send {
            background-color: #3b82f6;
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-send:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .alert {
            border-radius: 12px;
        }

        h2 {
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 25px;
        }

        @media (max-width: 576px) {
            .glass-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="glass-card">
    <h2 class="text-center">Hubungi Kami</h2>

    <?php if ($pesan): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($pesan) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap Anda" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Gmail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="contoh@gmail.com" required>
        </div>

        <div class="mb-3">
            <label for="pesan" class="form-label">Pesan</label>
            <textarea class="form-control" id="pesan" name="pesan" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
        </div>

        <div class="d-grid">
            <button style="color: white;" type="submit" class="btn btn-send">Kirim Pesan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
