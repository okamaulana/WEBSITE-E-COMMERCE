<?php
include 'config/db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $no_hp = $_POST["no_hp"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validasi password kuat
    if (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[\W]/', $password)
    ) {
        $message = "Password harus minimal 8 karakter, mengandung huruf besar, angka, dan simbol!";
    } else {
        $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $check->bind_param("ss", $email, $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Email atau Username sudah digunakan!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $insert = $conn->prepare("INSERT INTO users (email, no_hp, username, password, role) VALUES (?, ?, ?, ?, 'customer')");
            $insert->bind_param("ssss", $email, $no_hp, $username, $hashedPassword);

            if ($insert->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $message = "Gagal mendaftar. Coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar - okmweb</title>
    <!-- Favicon -->
    <link rel="icon" type="assets/png" href="assets/logotitle.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const icon = event.target;
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.textContent = "🙈";
        } else {
            passwordInput.type = "password";
            icon.textContent = "👁️";
        }
    }
</script>

    <style>
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: url('assets/background.jpeg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.4);
            width: 400px;
            text-align: center;
            backdrop-filter: blur(6px);
        }

        .register-container img {
            width: 100px;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 8px cyan);
        }

        .register-container h2 {
            color: cyan;
            margin-bottom: 25px;
            text-shadow: 0 0 5px cyan;
        }

        .register-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid cyan;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }

        .register-container input::placeholder {
            color: #ccc;
        }

        .register-container button {
            width: 100%;
            padding: 12px;
            background-color: cyan;
            color: black;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 15px;
            box-shadow: 0 0 10px cyan;
            transition: 0.3s ease;
        }

        .register-container button:hover {
            background-color: #00ffff;
            box-shadow: 0 0 20px cyan, 0 0 30px cyan;
        }

        .register-container .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .register-container .login-link {
            color: white;
            margin-top: 15px;
        }

        .register-container .login-link a {
            color: #00ffff;
            text-decoration: none;
        }

        @media (max-width: 500px) {
            .register-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <img src="assets/logotitle.png" alt="Logo okmweb">
    <h2>Daftar Akun</h2>
    <?php if ($message): ?>
        <div class="error"><?= $message; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required />
        <input type="text" name="no_hp" placeholder="Nomor HP" required />
        <input type="text" name="username" placeholder="Username" required />
        <div style="position: relative;">
    <input type="password" id="password" name="password" placeholder="Password" required />
    <span onclick="togglePassword()" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: cyan; font-size: 14px;">
        👁️
    </span>
</div>

        <button type="submit">Daftar</button>
    </form>
    <div class="login-link">
        Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
</div>


</body>
</html>
