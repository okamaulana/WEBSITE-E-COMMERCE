<?php
session_start();
require_once 'config/db.php'; // koneksi database
require_once 'google-config.php'; // konfigurasi Google Client

if (isset($_GET['code'])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $google_oauth = new Google_Service_Oauth2($google_client);
        $google_account_info = $google_oauth->userinfo->get();

        $email = $google_account_info->email;
        $username = explode('@', $email)[0];
        $foto = $google_account_info->picture;

        // Cek user
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $password = password_hash("google_auth", PASSWORD_BCRYPT);
            $no_hp = '-';
            $role = 'customer';

            $stmt = $conn->prepare("INSERT INTO users (email, no_hp, username, password, role, foto) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $email, $no_hp, $username, $password, $role, $foto);
            $stmt->execute();

            $user_id = $stmt->insert_id;
        } else {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];
        }

        // Ambil data user
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['id'];
$_SESSION['google_user'] = [
    'email' => $user['email'],
    'name' => $user['username']
];

        header("Location: index.php"); // redirect ke customer area
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
