<?php
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 'admin') {
        header("Location: admin/admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

// Mencegah browser menyimpan cache halaman login
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
include 'config/db.php'; // koneksi pakai $conn dari sini
require_once 'google-config.php';
$login_url = $google_client->createAuthUrl();



// Error default kosong
$error = "";

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameOrEmail = $_POST['username'];
    $passwordInput = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($passwordInput, $user['password'])) {
            // Tambahkan session yang dibutuhkan oleh dashboard
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id']; // <--- Tambahin ini!

        
            // Optional: kalau masih mau simpan data lainnya juga
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
        
            // Arahkan berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        
        
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username atau Email tidak ditemukan!";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login - OKMWEB</title>
    <!-- Favicon -->
    <link rel="icon" type="assets/png" href="assets/logol.jpg">
    <script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>

<script>
    window.history.forward();
    function noBack() { window.history.forward(); }
    setTimeout("noBack()", 0);
    window.onpageshow = function(evt) { if (evt.persisted) noBack(); };
    window.onunload = function() { void(0); };
</script>

<script>
    if (window.history && window.history.pushState) {
        window.history.pushState('no-back', null, null);
        window.onpopstate = function () {
            window.history.pushState('no-back', null, null);
        };
    }
</script>

    <style>
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(120deg, #000000, #0f0f0f);
            background-image: url('assets/background.jpeg');
            background-size: cover;
            background-position: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .back-button {
    position: absolute;
    top: 7px;
    left: 7px;
    padding: 7px 7px;
    font-size: 13px;
    color: #00ffff;
    border: 2px solid #00ffff;
    background: transparent;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s ease;
    box-shadow: 0 0 10px #00ffff50;
}

.back-button:hover {
    background-color: #00ffff;
    color: #000;
    box-shadow: 0 0 25px #00ffff, 0 0 40px #00ffff;
}

@media (max-width: 500px) {
  .back-button {
    font-size: 13px;
    padding: 8px 14px;
    top: 15px;
    left: 15px;
  }
}


        .login-container {
            background: rgba(0, 0, 0, 0.65);
            padding: 40px 30px;
            border-radius: 20px;
            width: 360px;
            text-align: center;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.6);
            backdrop-filter: blur(10px);
        }

        .login-container img {
            width: 120px;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 10px #00ffff);
        }

        .login-container h2 {
            color: #00ffff;
            margin-bottom: 25px;
            text-shadow: 0 0 10px #00ffff;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #00ffff;
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .login-container input::placeholder {
            color: #ccc;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background-color: #00ffff;
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 0 20px #00ffff;
            transition: 0.3s ease;
        }

        .login-container button:hover {
            background-color: #0ff;
            box-shadow: 0 0 30px #00ffff, 0 0 40px #00ffff;
        }

        .login-container .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .login-container .register {
            color: #fff;
            margin-top: 15px;
        }

        .login-container .register a {
            color: #00ffff;
            text-decoration: none;
        }

        @media (max-width: 500px) {
            .login-container {
                width: 90%;
            }

            .login-container img {
                width: 80px;
            }
        }

        @media screen and (min-width: 1024px) {
            .login-container {
                width: 400px;
            }
        }

        @media screen and (min-width: 1440px) {
            .login-container {
                width: 420px;
            }
        }

        @media screen and (min-width: 1900px) {
            .login-container {
                transform: scale(1.2);
            }
        }
    </style>
</head>
<body>



<div class="login-container">
    <img src="assets/logol.jpg" alt="Logo OKMWEB">
    <h2>Login OKMWEB</h2>
    <?php if ($error): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username atau Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>
    
    <div style="margin-top: 10px;">
        <a style="color: white">Kamu</a> <a href="lupa_sandi.php" style="color: #00ffff; text-decoration: none;">Lupa sandi?</a>
    </div>
    <div class="register">
        Belum punya akun? <a href="register.php">Daftar di sini</a>
    </div>
    <br>
    <a href="<?= $login_url ?>" class="btn btn-light border d-flex align-items-center justify-content-center gap-2 shadow-sm" style="border-radius: 8px; padding: 10px 20px;">
    <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" alt="Login with Google"style="width: 135px; height: auto;">
    </a>


</div>

</body>
</html>
