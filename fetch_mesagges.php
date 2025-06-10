<?php
session_start();
include 'config/db.php';

$pengirim_id = $_SESSION['user_id'];
$penerima_id = 1; // Ganti dengan ID penerima yang sesuai



// Ambil chat terbaru
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

// Tampilkan pesan chat
while ($row = $result_chat->fetch_assoc()) {
    echo '<div class="message ' . ($row['pengirim_id'] == $pengirim_id ? 'user' : 'admin') . '">';
    echo htmlspecialchars($row['pesan']);  // Tampilkan pesan

    // Jika ada file
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

// Tutup koneksi
$conn->close();
?>
