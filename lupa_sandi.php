<?php
include 'config/db.php'; // koneksi database

$pesan = "";
$submitted = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $password_baru = $_POST['password_baru'];

    // Cek ke database
    $sql = "SELECT * FROM users WHERE email = ? AND no_hp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $no_hp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pesan = urlencode("Halo Admin, saya ingin reset password:\n\nEmail: $email\nNo HP: $no_hp\nPassword Baru: $password_baru");
        $submitted = true;
    } else {
        $error = "Email atau No HP tidak ditemukan di database!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - okmweb</title>
    <link rel="icon" type="assets/png" href="assets/logotitle.png">
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(120deg, #000000, #0f0f0f);
            background-image: url('assets/background.jpeg');
            background-size: cover;
            background-position: center;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            background: rgba(0, 0, 0, 0.65);
            padding: 40px 30px;
            border-radius: 20px;
            width: 100%;
            max-width: 360px;
            text-align: center;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            color: white;
        }

        .reset-container h2 {
            color: #00ffff;
            margin-bottom: 20px;
        }

        .reset-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #00ffff;
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .reset-container input::placeholder {
            color: #ccc;
        }

        .reset-container button,
        .reset-container a.wa-btn {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background-color: #00ffff;
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 0 20px #00ffff;
            text-decoration: none;
            display: inline-block;
        }

        .reset-container button:hover,
        .reset-container a.wa-btn:hover {
            background-color: #0ff;
            box-shadow: 0 0 30px #00ffff, 0 0 40px #00ffff;
        }

        .reset-container .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .reset-container .back {
            margin-top: 20px;
            display: block;
            color: #00ffff;
            text-decoration: none;
        }

        @media (max-width: 480px) {
            .reset-container {
                padding: 30px 20px;
            }

            .reset-container h2 {
                font-size: 20px;
            }

            .reset-container input,
            .reset-container button,
            .reset-container a.wa-btn {
                font-size: 14px;
                padding: 10px;
            }

            .reset-container .back {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="reset-container">
        <h2>Reset Password</h2>
        <?php if (!$submitted): ?>
            <?php if ($error): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="no_hp" placeholder="Nomor HP" required>
                <input type="text" name="password_baru" placeholder="Password Baru" required>
                <button type="submit">Kirim Permintaan</button>
            </form>
            <a href="login.php" class="back">← Kembali ke Login</a>
        <?php else: ?>
            <p>Password baru siap dikirim via WhatsApp:</p>
            <a class="wa-btn" href="https://wa.me/6283116167606?text=<?= $pesan ?>" target="_blank">Kirim via WhatsApp</a>
            <a href="login.php" class="back">← Kembali ke Login</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
