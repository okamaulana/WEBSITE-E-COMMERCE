<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tentang Kami</title>
  <link rel="icon" type="assets/png" href="assets/logol.jpg">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: url('assets/background.jpeg') no-repeat center center fixed;
      background-size: cover;
      color: black;
    }
    header {
      text-align: center;
      padding: 5rem 2rem 3rem;
    }
    header h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
    }
    header p {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto;
      color: #040720;
    }
    .team {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      padding: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .card {
      color:black;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
    }
    .avatar img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
      object-fit: cover;
      margin-bottom: 1rem;
    }
    h3 {
      font-size: 1.3rem;
      margin: 0.5rem 0;
    }
    .role {
      color: #0000FF;
      font-weight: 600;
      margin-bottom: 1rem;
    }
    .desc {
      font-size: 0.95rem;
      color: black;
    }

    @media (max-width: 600px) {
      header h1 {
        font-size: 2rem;
      }

      .team {
        padding: 1rem;
      }

      .card {
        padding: 1.5rem;
        margin: 0.5rem 0;
        border-radius: 16px;
      }

      .avatar img {
        width: 100px;
        height: 100px;
      }

      .desc {
        font-size: 0.9rem;
        color:black;
      }
    }

    @media (min-width: 600px) and (max-width: 768px) {
      .team {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 1024px) {
      .team {
        grid-template-columns: repeat(3, 1fr);
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>TENTANG DEVELOPER</h1>
    <p>Kami adalah kumpulan profesional yang didorong oleh inovasi, keahlian, dan dedikasi penuh untuk menciptakan dampak positif melalui teknologi.</p>
  </header>

  <div class="team">
  <div class="card">
    <div class="card">
      <div class="avatar"><img src="assets/OKA.jpg" alt="Foto 1"></div>
      <h3>OKA MAULANA</h3>
      <p class="role">FULL-STACK DEVELOPER</p>
      <p class="desc">Bertanggung jawab dalam pengembangan teknis platform, baik sisi front-end maupun back-end. Mengintegrasikan fitur desain, sistem login, penyimpanan cloud, dan konektivitas ke media sosial.</p>
    </div>
   
    
    
    
  </div>

  <!-- Footer -->
<footer style="margin-top: 40px; padding: 20px; background-color: rgba(0,0,0,0.6); text-align: center; color: white; font-size: 14px;">
    <h3 style="color: cyan; margin-bottom: 15px;">Tentang Kami  </h3>
    <div style="max-width: 600px; margin: 0 auto; text-align: justify; padding: 20px; line-height: 1.8; font-size: 16px;">
    <p>
        <strong>OKMWEB</strong> adalah platform digital yang dirancang untuk membantu UMKM meningkatkan digitalisasi bisnis melalui pembuatan konten promosi berbasis desain kreatif. Kami hadir untuk mendukung pengembangan UMKM dalam menciptakan konten yang menarik dan berkualitas tinggi, sehingga meningkatkan daya saing, peluang bisnis, dan kesejahteraan masyarakat.
    </p>
    <p>
        Melalui OKMWEB, UMKM dapat meningkatkan kualitas branding, menjangkau lebih banyak pelanggan, serta memperkuat kehadiran bisnis mereka di ranah digital. Kami percaya bahwa dengan konten yang tepat, UMKM dapat berkembang lebih cepat dan berkontribusi pada pertumbuhan ekonomi lokal.
    </p>
</div>

    <p style="margin-top: 20px;">&copy; <?= date("Y") ?> OKMWEB. Semua hak dilindungi.</p>
</footer>


</body>
</html>
