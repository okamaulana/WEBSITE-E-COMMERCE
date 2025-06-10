<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


include 'config/db.php';
require_once 'google-config.php';
$login_url = $google_client->createAuthUrl();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pengirim_id = $_SESSION['user_id'];
$penerima_id = 1;

// Ini buat handle AJAX auto-refresh chat
if (isset($_GET['action']) && $_GET['action'] == 'load') {
  $sql_chat = "
    SELECT c.*, u.username 
    FROM chat c 
    JOIN users u ON u.id = c.pengirim_id
    WHERE (c.pengirim_id = $pengirim_id AND c.penerima_id = $penerima_id) 
       OR (c.pengirim_id = $penerima_id AND c.penerima_id = $pengirim_id)
    ORDER BY c.waktu_kirim ASC
  ";
  $conn = new mysqli("localhost", "root", "", "okmweb");
  if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
  }

  $result_chat = $conn->query($sql_chat);
  while ($row = $result_chat->fetch_assoc()) {
      echo '<div class="message ' . ($row['pengirim_id'] == $pengirim_id ? 'user' : 'admin') . '">';
      echo htmlspecialchars($row['pesan']);

      if ($row['file_path']) {
          $file_ext = strtolower(pathinfo($row['file_path'], PATHINFO_EXTENSION));
          if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
              echo "<img src='{$row['file_path']}' alt='Gambar'>";
          } elseif ($file_ext === 'pdf') {
              echo "<a href='{$row['file_path']}' target='_blank'>📄 Lihat PDF</a>";
          } else {
              echo "<a href='{$row['file_path']}' download>📁 Unduh File</a>";
          }
      }

      echo '</div>';
  }

  $conn->close();
  exit(); // Penting, biar ga lanjut ke HTML
}

$conn = new mysqli("localhost", "root", "", "okmweb");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Kirim pesan atau file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pesan = $conn->real_escape_string($_POST['pesan'] ?? '');
    $tipe_file = 'text';
    $file_path = null;

    if (!empty($_FILES['file']['name'])) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_name = time() . '_' . basename($_FILES['file']['name']);
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
            $file_path = $conn->real_escape_string($target_path);
            $tipe_file = 'file';
        }
    }

    if (!empty($pesan) || !empty($file_path)) {
        $sql = "INSERT INTO chat (pengirim_id, penerima_id, pesan, tipe_file, file_path)
                VALUES ($pengirim_id, $penerima_id, '$pesan', '$tipe_file', '$file_path')";
        $conn->query($sql);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil isi chat
$sql_chat = "
  SELECT c.*, u.username 
  FROM chat c 
  JOIN users u ON u.id = c.pengirim_id
  WHERE (c.pengirim_id = $pengirim_id AND c.penerima_id = $penerima_id) 
     OR (c.pengirim_id = $penerima_id AND c.penerima_id = $pengirim_id)
  ORDER BY c.waktu_kirim ASC
";
$result_chat = $conn->query($sql_chat);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Live Chat</title>
  <link rel="icon" type="assets/png" href="assets/logol.jpg">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  

  
  <!-- Link ke file CSS mobile khusus -->
  <link href="mobile.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <script>
// Fungsi untuk mengambil pesan baru secara berkala
function loadChat() {
    fetch("chat.php?action=load")
        .then(res => res.text())
        .then(html => {
            const chatBody = document.querySelector(".chat-body");
            chatBody.innerHTML = html;

            // Setelah memuat chat, pastikan scroll berada di bawah
            scrollToBottom();
        });
}

// Fungsi untuk scroll otomatis ke bawah
function scrollToBottom() {
    const chatBody = document.querySelector(".chat-body");
    chatBody.scrollTop = chatBody.scrollHeight;
}

// Memanggil loadChat setiap 2 detik untuk auto-refresh
setInterval(loadChat, 8000);
loadChat();

// Menangani pengiriman pesan
document.getElementById("chat-form").onsubmit = function (e) {
    e.preventDefault();
    const form = new FormData(this);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "chat.php?action=send", true);
    xhr.onload = function () {
        if (this.status === 200) {
            // Bersihkan input form setelah pesan dikirim
            document.querySelector("input[name='pesan']").value = "";
            document.querySelector("input[name='file']").value = "";

            // Panggil loadChat untuk memuat pesan setelah mengirim
            loadChat();

            // Pastikan scroll berada di bawah setelah pesan dikirim dan dimuat
            setTimeout(scrollToBottom, 100); // Delay 100ms untuk memastikan pesan baru dimuat
        }
    };
    xhr.send(form);
};



document.addEventListener("DOMContentLoaded", function () {
  if (performance && performance.navigation.type === 2) {
    // Halaman ini di-load kembali setelah back
    window.location.href = 'index.php'; // Redirect ke halaman index
  }
});


document.addEventListener("DOMContentLoaded", function() {
  if (performance && performance.navigation.type === 2) {
    // User menekan back
    window.location.href = 'index.php';
  }
});


window.addEventListener('pageshow', function(event) {
  if (event.persisted) {
    // Halaman dimuat dari cache karena back/forward
    window.location.href = 'index.php';
  }
});




</script>
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }

    .container {
      display: flex;
      height: 100vh;
    }

    .left-side {
  flex: 1;
  background: url('assets/ctp.jpg') no-repeat center center;
  background-size: cover;
  color: white;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}



    .left-side h1 {
      font-size: 36px;
      margin-bottom: 20px;
    }

    .left-side p {
      font-size: 18px;
      line-height: 1.6;
    }

    .right-side {
      flex: 2;
      background-color: white;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    .chat-header {
      font-weight: bold;
      font-size: 24px;
      border-bottom: 2px solid #ccc;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .chat-body {
      flex: 1;
      overflow-y: auto;
      margin-bottom: 20px;
    }

    .message {
      padding: 10px 15px;
      border-radius: 20px;
      margin: 5px 0;
      background-color: #f1f2f6;
      max-width: 100%;
      width: fit-content;
      word-break: break-word;
    }

    .user {
      background-color: #3498db;
      color: white;
      margin-left: auto;
      text-align: right;
    }

    .admin {
      background-color: #ecf0f1;
      color: black;
      margin-right: auto;
      text-align: left;
    }

    .file-display {
      margin-top: 5px;
      font-size: 14px;
    }

    .chat-footer {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .chat-footer input[type="text"],
    .chat-footer input[type="file"] {
      padding: 10px;
      border-radius: 20px;
      border: 1px solid #ccc;
    }

    .chat-footer input[type="text"] {
      flex: 1;
    }

    .chat-footer button {
      padding: 10px 20px;
      border: none;
      background-color: #3498db;
      color: white;
      border-radius: 20px;
      cursor: pointer;
    }

    .chat-footer button:hover {
      background-color: #2980b9;
    }

    img {
      max-width: 200px;
      max-height: 200px;
      border-radius: 10px;
      display: block;
      margin-top: 5px;
    }

    .back-btn {
  display: none;
  position: fixed;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  background-color: rgba(52, 152, 219, 0.95);
  color: white;
  padding: 8px 16px;
  border-radius: 20px;
  text-decoration: none;
  font-size: 14px;
  z-index: 9999;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  transition: background-color 0.3s;
}

.back-btn:hover {
  background-color: rgba(41, 128, 185, 0.95);
}

.back-btn {
    display: block; /* Default behavior */
}


    
    @media screen and (max-width: 768px) {

  
  .container {
    flex-direction: column;
    height: auto;
  }

  .left-side {
  padding: 5px 10px; /* lebih tipis */
  text-align: center;
}



.left-side p {
  font-size: 10px;
  margin: 0;
  padding: 0;
  line-height: 1;
}


.right-side {
  display: flex;
  flex-direction: column;
  height: 100vh; /* penuh layar */
}




.chat-body {
  background: url('assets/background.jpeg') no-repeat center center fixed;
  background-size: cover;
  background-attachment: fixed; /* Ini bikin background-nya diam */
  position: absolute; /* Menggunakan absolute supaya elemen ini memenuhi lebar layar */
  top: 0;              /* Mengatur posisi ke atas */
  left: 0;             /* Mengatur posisi ke kiri */
  width: 100%;         /* Memastikan elemen memenuhi lebar layar */
  height: 100%;        /* Memastikan elemen memenuhi tinggi layar */
  overflow-y: auto;    /* Agar chat bisa scroll secara vertikal */
  padding: 10px;
  padding-bottom: 90px; /* tambahin padding supaya nggak ketutupan footer */
  z-index: 1;          /* Pastikan elemen ini tetap di atas konten lainnya */
  
}


  .message {
    max-width: 80%;
  }

  .chat-footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: white;
  display: flex;
  justify-content: space-between;
  gap: 10px;
  padding: 10px;
  border-top: 1px solid #ddd;
  z-index: 100;
}





  .chat-footer input[type="text"] {
    flex: 3;
    font-size: 14px;
    padding: 8px;
    margin: 0 10px;
    border-radius: 20px;
    border: 1px solid #ccc;
  }

  /* Menyembunyikan input file */
  .chat-footer input[type="file"] {
    display: none;
  }

  /* Menambahkan label dengan ikon untuk choose file */
  .chat-footer label {
    font-size: 24px;
    cursor: pointer;
    color: #3498db;
  }

  .chat-footer button {
    flex: 1;
    max-width: 100px;
    font-size: 14px;
    padding: 8px;
    background-color: #3498db;
    color: white;
    border-radius: 20px;
    border: none;
  }

  img {
    max-width: 100%;
    height: auto;
  }
}



    
  </style>
</head>
<body>
<a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> DASHBOARD</a>


  
  <div class="container">
  <div class="left-side" style="display: flex; align-items: center;">
  <img src="assets/logol.jpg" alt="Logo" style="height: 186px; margin-right: 18px;">

</div>




    <div class="right-side">
    <div style="margin-bottom: 10px;">

</div>
  
<div class="chat-body">
  <?php while ($row = $result_chat->fetch_assoc()): ?>
    <div class="message <?= ($row['pengirim_id'] == $pengirim_id) ? 'user' : 'admin' ?>">
      <?= htmlspecialchars($row['pesan']) ?>

      <?php if ($row['file_path']): ?>
        <div class="file-display">
          <?php
            $file_ext = strtolower(pathinfo($row['file_path'], PATHINFO_EXTENSION));
            if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
              echo "<img src='{$row['file_path']}' alt='Gambar'>";
            } elseif ($file_ext === 'pdf') {
              echo "<a href='{$row['file_path']}' target='_blank'>📄 Lihat PDF</a>";
            } else {
              echo "<a href='{$row['file_path']}' download>📁 Unduh File</a>";
            }
          ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
</div>

<div class="chat-footer">
  <form action="chat.php" method="post" enctype="multipart/form-data" style="display: flex; gap: 10px; width: 100%; justify-content: center;">
    <!-- Label dengan ikon untuk choose file -->
    <label for="file" class="fas fa-paperclip"></label>
    <input type="file" name="file" id="file" />
    
    <!-- Kotak pesan di tengah -->
    <input type="text" name="pesan" placeholder="Ketik pesan..." />
    <button type="submit">Kirim</button>
  </form>
</div>


