<?php
// --- Koneksi Database ---
$conn = new mysqli("localhost", "root", "", "okmweb");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

session_start();
$admin_id = 1; // Ganti sesuai ID admin login
$customer_id = $_GET['user_id'] ?? null;

// AJAX Handler untuk memuat chat
if (isset($_GET['action']) && $_GET['action'] == 'load' && isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    $msgs = $conn->query("SELECT * FROM chat WHERE 
        (pengirim_id=$admin_id AND penerima_id=$user_id) OR
        (pengirim_id=$user_id AND penerima_id=$admin_id)
        ORDER BY waktu_kirim ASC");
    
    while ($msg = $msgs->fetch_assoc()) {
        $class = $msg['pengirim_id'] == $admin_id ? 'you' : 'them';
        $file_display = '';

        // Jika ada file yang di-upload, tampilkan link untuk mengunduh
        if ($msg['file_path']) {
            $file_display = "<div class='file'><a href='" . htmlspecialchars($msg['file_path']) . "' target='_blank'>Lihat file</a></div>";
        }

        echo "<div class='$class'><p>" . htmlspecialchars($msg['pesan']) . "</p><small>" . $msg['waktu_kirim'] . "</small>$file_display</div>";
    }
    exit;
}

// AJAX Handler untuk mengirim pesan
if (isset($_GET['action']) && $_GET['action'] == 'send') {
    $pengirim_id = intval($_POST['pengirim_id']);
    $penerima_id = intval($_POST['penerima_id']);
    $pesan = $conn->real_escape_string($_POST['pesan']);
    $file_path = '';

    // Cek apakah ada file yang di-upload
    if ($_FILES['file']['name']) {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_path = "uploads/" . basename($file_name);
        move_uploaded_file($file_tmp, $file_path);
    }

    // Insert pesan ke dalam database
    $conn->query("INSERT INTO chat (pengirim_id, penerima_id, pesan, file_path) VALUES ($pengirim_id, $penerima_id, '$pesan', '$file_path')");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
    <link rel="icon" type="assets/png" href="assets/logotitle.png">
    <script>
// Fungsi untuk mengambil pesan baru secara berkala
function loadChat() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "admin_chat.php?action=load&user_id=" + <?= $customer_id ?>, true);
    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById("chat-box").innerHTML = this.responseText;
            document.getElementById("chat-box").scrollTop = document.getElementById("chat-box").scrollHeight;
        }
    };
    xhr.send();
}

// Ambil pesan setiap 2 detik
<?php if ($customer_id): ?>
setInterval(loadChat, 2000);
loadChat();

// Menangani pengiriman pesan
document.getElementById("chat-form").onsubmit = function (e) {
    e.preventDefault();
    const form = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "admin_chat.php?action=send", true);
    xhr.onload = function () {
        if (this.status === 200) {
            document.querySelector("input[name='pesan']").value = "";
            document.querySelector("input[name='file']").value = "";
            loadChat();  // Memuat chat setelah mengirim pesan
        }
    };
    xhr.send(form);
};
<?php endif; ?>
</script>


    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #f2f4f8;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar h3 {
            margin-top: 0;
            font-size: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 8px 10px;
            border-radius: 5px;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #34495e;
        }

        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .chat-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .chat-box {
            flex: 1;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow-y: auto;
            padding: 15px;
        }

        .chat-box .you {
            text-align: right;
            margin: 10px 0;
        }

        .chat-box .them {
            text-align: left;
            margin: 10px 0;
        }

        .chat-box p {
            display: inline-block;
            padding: 10px;
            border-radius: 10px;
            max-width: 60%;
            margin: 0;
        }

        .you p {
            background-color: #dff9fb;
            color: #2d3436;
        }

        .them p {
            background-color: #f1f2f6;
            color: #2d3436;
        }

        .chat-box small {
            display: block;
            font-size: 11px;
            margin-top: 2px;
            color: #999;
        }

        .file {
            background-color: #2980b9;
            color: white;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            margin-top: 5px;
        }

        form {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #3498db;
        }

        .file-input {
            display: inline-block;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3>Daftar Customer</h3>
    <ul>
        <?php
        $users = $conn->query("SELECT * FROM users WHERE role='customer'");
        while ($u = $users->fetch_assoc()) {
            $active = ($customer_id == $u['id']) ? 'class="active"' : '';
            echo '<li><a ' . $active . ' href="?user_id=' . $u['id'] . '">' . htmlspecialchars($u['username']) . '</a></li>';
        }
        ?>
    </ul>
</div>

<!-- Chat Area -->
<div class="chat-area">
<a href="admin/admin_dashboard.php" style="
    position: absolute;
    right: 20px;
    top: 20px;
    background: #e74c3c;
    color: white;
    padding: 8px 14px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    font-size: 13px;
    z-index: 10;
">← Back</a>

    <?php if ($customer_id): ?>
        <?php
        $customer = $conn->query("SELECT * FROM users WHERE id=$customer_id")->fetch_assoc();
        ?>
        <div class="chat-header">Chat dengan <?= htmlspecialchars($customer['username']) ?></div>

        <div id="chat-box" class="chat-box">
            <!-- Chat akan di-load via AJAX -->
        </div>

        <form id="chat-form" enctype="multipart/form-data">
            <input type="hidden" name="pengirim_id" value="<?= $admin_id ?>">
            <input type="hidden" name="penerima_id" value="<?= $customer_id ?>">
            <input type="text" name="pesan" placeholder="Ketik pesan..." required>
            <input type="file" name="file" class="file-input">
            <button type="submit">Kirim</button>
        </form>
    <?php else: ?>
        <p>Silakan pilih customer untuk memulai chat.</p>
    <?php endif; ?>
</div>

<!-- AJAX JS -->
<script>
function loadChat() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "admin_chat.php?action=load&user_id=<?= $customer_id ?>", true);
    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById("chat-box").innerHTML = this.responseText;
            document.getElementById("chat-box").scrollTop = document.getElementById("chat-box").scrollHeight;
        }
    };
    xhr.send();
}

<?php if ($customer_id): ?>
setInterval(loadChat, 2000);
loadChat();

document.getElementById("chat-form").onsubmit = function (e) {
    e.preventDefault();
    const form = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "admin_chat.php?action=send", true);
    xhr.onload = function () {
        if (this.status === 200) {
            document.querySelector("input[name='pesan']").value = "";
            document.querySelector("input[name='file']").value = "";
            loadChat();
        }
    };
    xhr.send(form);
};
<?php endif; ?>
</script>

</body>
</html>
