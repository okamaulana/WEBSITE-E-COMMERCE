<?php
session_start();
$conn = new mysqli("localhost", "root", "", "okmweb");

$id = intval($_GET['id']);

// Proses kirim ulasan (langsung di sini)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $produk_id = intval($_POST['produk_id']);
    $isi = $conn->real_escape_string($_POST['isi']);

    if (!empty($isi)) {
        $conn->query("INSERT INTO ulasan (produk_id, user_id, isi, tanggal) 
                      VALUES ($produk_id, $user_id, '$isi', NOW())");
        header("Location: detail_produk.php?id=$produk_id");
        exit;
    }
}

// Ambil detail produk
$query = $conn->query("SELECT produk.*, kategori.nama AS kategori_nama FROM produk 
    LEFT JOIN kategori ON produk.kategori_id = kategori.id 
    WHERE produk.id = $id");
$produk = $query->fetch_assoc();
$fotoList = json_decode($produk['foto']);

// Ambil ulasan
$ulasanQuery = $conn->query("SELECT ulasan.*, users.username, users.foto AS user_foto 
    FROM ulasan 
    JOIN users ON ulasan.user_id = users.id 
    WHERE produk_id = $id 
    ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produk['nama']) ?> - OKMWEB</title>
    <!-- Favicon -->
    <link rel="icon" type="assets/png" href="assets/logol.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('assets/background.jpeg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
           
         
            font-weight: 600;
            font-size: 24px;
            color: #6f42c1;
        }
        
        .card { border: none; border-radius: 16px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06); background: #fff; }
        .carousel-inner img { border-radius: 16px 16px 0 0; height: 350px; object-fit: cover; }
        .produk-title { font-size: 28px; font-weight: 600; }
        .produk-kategori { font-size: 14px; color: #888; }
        .produk-harga { color: #0d6efd; font-size: 22px; font-weight: 600; }
        .btn-pesan { border-radius: 10px; padding: 10px 24px; }
        .kembali-link { text-decoration: none; font-weight: 500; color: #0d6efd; margin-bottom: 20px; display: inline-block; }
        .ulasan-box { background: #fff; padding: 15px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 15px; }
        .ulasan-box img { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 10px; }   .panel-ulasan {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        max-height: 400px;
        overflow-y: auto;
    }

    .ulasan-item img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .ulasan-item strong {
        font-size: 1rem;
        color: #222;
    }

    .ulasan-item small {
        color: #888;
        font-size: 0.8rem;
    }

    .ulasan-item p {
        font-size: 0.95rem;
        color: #333;
    }

    .ulasan-item:not(:last-child) {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

           /* Agar dropdown tidak bercampur dengan layout lain */
.dropdown-menu {
    z-index: 1050; /* Pastikan dropdown berada di atas layout lainnya */
    position: absolute; /* Atur posisi absolute jika perlu */
}

.dropdown-toggle::after {
    visibility: hidden; /* Menyembunyikan tanda panah pada tombol dropdown */
}

    @media (max-width: 768px) {
    .navbar-nav .nav-link,
    .navbar-nav .dropdown-toggle {
        width: 100%;
        text-align: left;
    }

    .dropdown-menu {
        width: 100%;
    }
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="assets/logol.jpg" alt="Logo" style="height: 40px; margin-left: 8.2px;" class="me-2">
            OKMWEB
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAlt">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAlt" style="margin-right: 0.01px;">
        <ul class="navbar-nav ms-auto d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
        <a class="nav-link" style="color: #6f42c1;" href="hubungi-kami.php">Hubungi kami!</a>
                <a class="nav-link" style="color: #6f42c1;" href="tentang.php">Tentang</a>
                <a class="nav-link " style="color: #6f42c1;" href="https://wa.me/6282287956090?text=Halo%2C%20saya%20mau%20tanya%20tentang%20produk%20Anda" target="_blank">Kontak</a>

        <?php if (isset($_SESSION['user'])): ?>
    <li class="nav-item dropdown">

        <button class="btn dropdown-toggle nav-link text-dark bg-transparent border-0" type="button" id="akunDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Halo, <?= htmlspecialchars($_SESSION['user']['username']) ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="akunDropdown">
            <li><a class="dropdown-item" href="customer/edit_akun.php">Edit Akun</a></li>
            <li><a class="dropdown-item" href="chat.php">Chat Project</a></li>
            <li><a class="dropdown-item" href="riwayat.php">Riwayat</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
        </ul>
    </div>
<?php else: ?>
    <a class="nav-link text-dark" href="login.php">Login</a>
<?php endif; ?>

    </div>
</div>

        </div>
    </div>
</nav>

<div class="container py-5">
    <a href="index.php" class="kembali-link">← Kembali ke Beranda</a>

    <div class="card overflow-hidden mb-4">
        <div class="row g-0">
            <div class="col-md-6">
                <div id="carouselProduk" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner h-100">
                        <?php foreach ($fotoList as $i => $foto): ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                <img src="uploads/produk/<?= htmlspecialchars($foto) ?>" class="d-block w-100" alt="Foto Produk">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($fotoList) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduk" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselProduk" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6 p-4 d-flex flex-column justify-content-between">
                <div>
                    <h1 class="produk-title"><?= htmlspecialchars($produk['nama']) ?></h1>
                    <p class="produk-kategori">Kategori: <?= htmlspecialchars($produk['kategori_nama']) ?></p>
                    <p><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>
                </div>
                <div>
                    <p class="produk-harga">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
                    <?php
    $namaProduk = urlencode($produk['nama']);
    $hargaProduk = number_format($produk['harga'], 0, ',', '.');
    $linkProduk = urlencode("http://localhost/okmweb/detail_produk.php?id={$produk['id']}"); // Ganti domainkamu.com dengan domain asli kamu
    $pesanWA = "Halo, saya tertarik membeli produk berikut:%0A%0A"
             . "Nama Produk: {$namaProduk}%0A"
             . "Harga: Rp {$hargaProduk}%0A"
             . "Link Produk: {$linkProduk}";
    $nomorWA = "6282287956090"; // Ganti dengan nomor WhatsApp kamu
?>

<a href="https://wa.me/<?= $nomorWA ?>?text=<?= $pesanWA ?>" target="_blank" class="btn btn-primary btn-pesan mt-2">
    Pesan Sekarang
</a>
                </div>
            </div>
        </div>
    </div>

    <h4 style="color:#F7CAC9;" class="mb-3">Ulasan Pengguna</h4>

<div class="panel-ulasan p-3 bg-white shadow-sm rounded">
    <?php while ($ulasan = $ulasanQuery->fetch_assoc()): ?>
        <div class="ulasan-item d-flex align-items-start mb-3">
            <img src="uploads/<?= htmlspecialchars($ulasan['user_foto']) ?>" alt="User" />
            <div class="ms-3">
                <strong><?= htmlspecialchars($ulasan['username']) ?></strong><br>
                <small class="text-muted"><?= $ulasan['tanggal'] ?></small>
                <p class="mb-0"><?= nl2br(htmlspecialchars($ulasan['isi'])) ?></p>
            </div>
        </div>
    <?php endwhile; ?>
</div>



    <?php if (isset($_SESSION['user'])): ?>
        <form method="POST" class="mt-4">
            <input type="hidden" name="produk_id" value="<?= $id ?>">
            <div class="mb-3">
                <label for="isi" style="color:#F7CAC9;"class="form-label">Tulis ulasan Anda</label>
                <textarea name="isi" id="isi" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Kirim Ulasan</button>
        </form>
    <?php else: ?>
        <p class="text-muted">Silakan <a href="login.php">login</a> untuk menulis ulasan.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
