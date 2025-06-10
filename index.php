<?php
session_start();

$conn = new mysqli("localhost", "root", "", "okmweb");

$search = $_GET['search'] ?? '';
$filterKategori = $_GET['kategori'] ?? '';

$kategoriQuery = $conn->query("SELECT * FROM kategori");
$kategori = [];
while ($row = $kategoriQuery->fetch_assoc()) {
    $kategori[] = $row;
}

$where = "1=1";
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $where .= " AND produk.nama LIKE '%$search%'";
}
if (!empty($filterKategori)) {
    $filterKategori = intval($filterKategori);
    $where .= " AND produk.kategori_id = $filterKategori";
}

$produkQuery = $conn->query("SELECT produk.*, kategori.nama AS kategori_nama FROM produk LEFT JOIN kategori ON produk.kategori_id = kategori.id WHERE $where");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>OKM WEB</title>
    <!-- Favicon -->
    <link rel="icon" type="assets/png" href="assets/logol.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

 




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

        .sidebar {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .list-group-item.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .produk-card .card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            transition: transform 0.3s ease;
        }

        .produk-card .card:hover {
            transform: translateY(-5px);
        }

        .carousel img {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 18px;
        }

        .card-title {
            font-weight: 600;
        }

        .text-muted {
            font-size: 14px;
        }

        .text-primary {
            font-size: 16px;
            font-weight: 500;
        }

        .form-control, .btn {
            border-radius: 10px;
        }

        footer {
            text-align: center;
            padding: 30px 0 10px;
            color: #999;
            font-size: 14px;
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="assets/logol.jpg" alt="Logo" style="height: 70px; margin-right:70px;" class="me-2">
            OKM WEB
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAlt">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAlt" style="margin-right: 8px;">
        <ul class="navbar-nav ms-auto d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">

            <a class="nav-link" style="color: #6f42c1;" href="hubungi-kami.php">Hubungi kami</a>
                <a class="nav-link" style="color: #6f42c1;" href="tentang.php">Tentang</a>
                <a class="nav-link " style="color: #6f42c1;" href="https://wa.me/6282287956090?text=Halo%2C%20saya%20mau%20tanya%20tentang%20produk%20Anda" target="_blank">Kontak</a>
               <!-- Dropdown untuk Akun -->
<?php if (isset($_SESSION['user'])): ?>
    <li class="nav-item dropdown">

        <button class="btn dropdown-toggle nav-link text-dark bg-transparent border-0" type="button" id="akunDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Halo, <?= htmlspecialchars($_SESSION['user']['username']) ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="akunDropdown">
            <li><a class="dropdown-item" href="customer/edit_akun.php">Edit Akun</a></li>
            <li><a class="dropdown-item" href="chat.php">Chat Project</a></li>
            <li><a class="dropdown-item" href="customer/status_produk.php">Status Produk</a></li>
           
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
</nav>

<!-- Konten -->
<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="sidebar">
                <h5 class="mb-3">Kategori</h5>
                <div class="list-group">
                    <a href="index.php" class="list-group-item list-group-item-action <?= $filterKategori == '' ? 'active' : '' ?>">Semua</a>
                    <?php foreach ($kategori as $k): ?>
                        <a href="?kategori=<?= $k['id'] ?>" class="list-group-item list-group-item-action <?= $filterKategori == $k['id'] ? 'active' : '' ?>">
                            <?= htmlspecialchars($k['nama']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Produk -->
        <div class="col-md-9">
            <form class="input-group mb-4" method="get">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="<?= htmlspecialchars($search) ?>">
                <?php if ($filterKategori): ?>
                    <input type="hidden" name="kategori" value="<?= $filterKategori ?>">
                <?php endif; ?>
                <button class="btn btn-primary" type="submit">Cari</button>
            </form>

            <div class="row">
                <?php while ($p = $produkQuery->fetch_assoc()): ?>
                    <div class="col-md-6 mb-4 produk-card">
                    <a href="detail_produk.php?id=<?= $p['id'] ?>" style="text-decoration: none; color: inherit;">
                    <div class="card">
                            <?php
                            $fotos = json_decode($p['foto'], true);
                            ?>
                            <div id="carousel<?= $p['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($fotos as $index => $foto): ?>
                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="uploads/produk/<?= htmlspecialchars($foto) ?>" class="d-block w-100" alt="Foto Produk">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                                    </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($p['nama']) ?></h5>
                                <p class="text-muted"><?= htmlspecialchars($p['kategori_nama']) ?></p>
                                <p class="text-primary">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
                                <p><?= htmlspecialchars($p['deskripsi']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    &copy; <?= date('Y') ?> OKMWEB. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
