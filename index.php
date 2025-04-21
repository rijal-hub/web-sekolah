<?php
// Include file db_connect.php untuk koneksi ke database
include 'config/db_connect.php';
$query = "SELECT * FROM slider ORDER BY id DESC";
$result = mysqli_query($conn, $query);
// ID tetap 1
$id = 1;

// Query untuk mengambil data beranda berdasarkan id = 1
$query = "SELECT * FROM beranda WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $beranda = $result->fetch_assoc();
} else {
    echo "Data beranda tidak ditemukan.";
    exit;
}

// Query untuk mengambil data kontak
$query_kontak = "SELECT * FROM kontak WHERE id = ?";
$stmt_kontak = $conn->prepare($query_kontak);
$stmt_kontak->bind_param("i", $id);
$stmt_kontak->execute();
$result_kontak = $stmt_kontak->get_result();

// Cek apakah data kontak ditemukan
if ($result_kontak->num_rows > 0) {
    $kontak = $result_kontak->fetch_assoc();
} else {
    echo "Data kontak tidak ditemukan.";
    exit;
}

// Query untuk mengambil data berita terbaru dari tabel berita_sekolah
$query_berita = "SELECT id, judul, isi, tanggal, media, kategori 
                FROM berita_sekolah 
                ORDER BY tanggal DESC 
                LIMIT 3";
$stmt_berita = $conn->prepare($query_berita);

// Periksa apakah prepare berhasil
if ($stmt_berita === false) {
    die("Error preparing statement: " . $conn->error);
}

if (!$stmt_berita->execute()) {
    die("Error executing statement: " . $stmt_berita->error);
}

$result_berita = $stmt_berita->get_result();

if ($result_berita === false) {
    die("Error getting result set: " . $conn->error);
}

$berita_items = $result_berita->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
<style>
    /* Section Berita Terbaru */

    .news-card {
        display: flex;
        gap: 20px;
        border-left: 3px solid #1977cc;
        padding: 15px;
        margin-bottom: 20px;
        transition: all 0.3s ease-in-out;
        align-items: center;
    }
    
    .news-image {
        width: 120px;
        height: 80px;
        border-radius: 5px;
        object-fit: cover;
        flex-shrink: 0;
    }
    
    .news-content {
        flex: 1;
    }
    
    .news-date {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .news-date i {
        color: #1977cc;
        margin-right: 5px;
    }
    
    .news-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .news-section {
        background-color: #f8f9fa;
        padding: 60px 0;
    }
    
    .section-title {
        text-align: center;
        padding-bottom: 30px;
    }
    
    .section-title h2 {
        font-size: 32px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 20px;
        padding-bottom: 20px;
        position: relative;
        color: #2c4964;
    }
    
    .section-title h2::before {
        content: "";
        position: absolute;
        display: block;
        width: 120px;
        height: 1px;
        background: #ddd;
        bottom: 1px;
        left: calc(50% - 60px);
    }
    
    .section-title h2::after {
        content: "";
        position: absolute;
        display: block;
        width: 40px;
        height: 3px;
        background: #1977cc;
        bottom: 0;
        left: calc(50% - 20px);
    }
    
    .news-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 0 30px rgba(1, 41, 112, 0.08);
        overflow: hidden;
        padding: 30px;
    }
    
    .news-card {
        border-left: 3px solid #1977cc;
        padding: 15px 0 15px 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease-in-out;
    }
    
    .news-card:hover {
        transform: translateX(5px);
    }
    
    .news-date {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .news-date i {
        color: #1977cc;
        margin-right: 5px;
    }
    
    .news-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .news-title a {
        color: #2c4964;
        transition: 0.3s;
        text-decoration: none;
    }
    
    .news-title a:hover {
        color: #1977cc;
    }
    
    .news-more {
        text-align: center;
        margin-top: 20px;
    }
    
    .news-more a {
        color: #1977cc;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .news-more a i {
        margin-left: 5px;
        transition: 0.3s;
    }
    
    .news-more a:hover i {
        transform: translateX(5px);
    }
  </style>

  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Beranda</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Company
  * Template URL: https://bootstrapmade.com/company-free-html-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    
    <div class="container position-relative d-flex ">

      <a href="index.php" class="logo d-flex align-items-center me-auto">

      <img src="aset/logo sd.png" alt="Logo SD" class="logo-img">
        <h1 class="sitename">SDN BANGETAYU WETAN 02</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Beranda</a></li>
          <li class="dropdown"><a href="profil_sekolah.php"> <span>profil</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="profil_sekolah.php">Profil sekolah</a></li>
              <li><a href="team.php"> Daftar Guru</a></li>
              <li><a href="prestasi_sekolah.php">Prestasi sekolah</a></li>
            </ul>
          </li>
          <li><a href="lomba.php">Lomba</a></li>
          <li><a href="warta.php">Warta sekolah</a></li>
          <li class="dropdown"><a href="https://ppid.semarangkota.go.id/informasi-penerimaan-calon-peserta-didik-baru/"> <span>website terkait</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="https://ppid.semarangkota.go.id/informasi-penerimaan-calon-peserta-didik-baru/" >Pendaftaran siswa</a></li>
              <li><a href="https://sangjuara.semarangkota.go.id/kejuaraan_siswa?tingkat=&sekolah=309&q="> Sang Juara</a></li>
              
            </ul>
          </li>
          <li><a href="contact.php">Kontak</a></li>
          <li id="admin-login-btn" style="display: none;">
          <a href="login.php" class="login-box">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    
<section id="hero" class="hero section dark-background">
    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php
            // Cek apakah ada data gambar
            if (mysqli_num_rows($result) > 0) {
                $first = true;
                // Loop untuk menampilkan gambar-gambar dari slider
                while ($row = mysqli_fetch_assoc($result)) {
                    $foto = $row['foto']; // Nama file foto
                    $active_class = $first ? 'active' : ''; // Set class active untuk item pertama
                    $first = false;
                    echo "
                    <div class='carousel-item $active_class'>
                        <img src='admin/beranda/uploads/$foto' alt='Slider Image'>
                    </div>";
                }
            } else {
                echo "<p>No images available in the slider.</p>";
            }
            ?>
        </div>

        <!-- Carousel Controls -->
        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

        <!-- Carousel Indicators -->
        <ol class="carousel-indicators">
            <?php
            // Generate indicators for the carousel based on the number of images
            mysqli_data_seek($result, 0); // Reset the pointer to the first row
            $index = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li data-bs-target='#hero-carousel' data-bs-slide-to='$index' class='" . ($index == 0 ? 'active' : '') . "'></li>";
                $index++;
            }
            ?>
        </ol>
    </div>
</section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
  <div class="container">
    <div class="row position-relative">

    <div class="col-lg-7 about-img" data-aos="zoom-out" data-aos-delay="200">
    <img src="admin/beranda/uploads/<?php echo $beranda['foto_kepsek']; ?>" alt="Foto Kepala Sekolah" width="200">
</div>

      <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
        <h2 class="inner-title">Sambutan Kepala Sekolah</h2>
        <div class="our-story">
          <h5>Kepala Sekolah SDN 02 Bangetayu Wetan</h5>
          <h3><?php echo $beranda['Nama_Kepsek']; ?></h3>
          <?php
            $paragraf = explode("\n", $beranda['sambutan']);
            foreach ($paragraf as $p) {
              echo "<p>" . nl2br(trim($p)) . "</p>";
            }
          ?>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Berita Terbaru Section dengan Foto -->
<!-- Berita Terbaru Section dengan Foto -->
<section id="news" class="news-section">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Berita Terbaru</h2>
        <p>Informasi terkini dari SDN Bangetayu Wetan 02</p>
      </div>

      <div class="news-container">
        <?php foreach ($berita_items as $berita): ?>
        <!-- Loop melalui setiap berita -->
        <div class="news-card">
          <?php if (!empty($berita['media'])): ?>
          <img src="admin/berita_sekolah/uploads/<?php echo htmlspecialchars($berita['media']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="news-image">
          <?php endif; ?>
          <div class="news-content">
            <div class="news-date">
              <i class="bi bi-calendar-event"></i> 
              <?php 
                if (!empty($berita['tanggal'])) {
                  $tanggal = new DateTime($berita['tanggal']);
                  echo $tanggal->format('d F Y'); 
                }
              ?>
            </div>
            <h3 class="news-title">
            <a href="detail_warta.php?id=<?= $berita['id'] ?>">
    <?= htmlspecialchars($berita['judul']) ?>
</a>
            </h3>
            <p><?php echo !empty($berita['kategori']) ? 'Kategori: ' . htmlspecialchars($berita['kategori']) : ''; ?></p>
          </div>
        </div>
        <?php endforeach; ?>

        <div class="news-more">
          <a href="warta.php">Lihat Semua Berita <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div>
</section>


    <!-- Services Section -->


    <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
            <h4>Alamat</h4>
            <p><?php echo nl2br(htmlspecialchars($kontak['alamat'])); ?></p>
            <p class="mt-3"><strong> Nomor telp:</strong> <?php echo nl2br(htmlspecialchars($kontak['telepon'])); ?></p>
            <p><strong>Email:</strong> <?php echo nl2br(htmlspecialchars($kontak['email'])); ?></p>
         
        </div>
    
        <div class="col-lg-3 col-md-6  align-items-center footer-links">
          <h4>Tautan</h4>
          <ul>
            <li><a href="https://www.kemdikbud.go.id/"> Kemendikbud</a></li>
            <li><a href="https://disdiksmg.semarangkota.go.id/">Dinas Pendidikan</a></li>
          </ul>
          <div class="social-links d-flex mt-4">
            <a href="https://www.facebook.com/share/1NbvshQNt8/"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/sdnbangetayuwetan02"><i class="bi bi-instagram"></i></a>
            <a href="https://www.youtube.com/@sdnegeribangetayuwetan0259"><i class="bi bi-youtube"></i></a>
          </div>
        </div>
    
        <div class="col-lg-4 col-md-6 footer-about">
          <h4>Umpan Balik</h4>
          <p>Silakan berikan kritik dan saran Anda untuk membantu kami menjadi lebih baik.</p>
          <br>
          <a href="contact.php" class="btn btn-dark">Berikan Umpan Balik</a>

        </div>
      </div>
    </div>    

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p> <span></span> <strong class="px-1 sitename"></strong> <span> &copy; 2025 SDN Bangetayu Wetan 02</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        <a href="https://bootstrapmade.com/"></a><a href=“https://themewagon.com>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
  document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key.toLowerCase() === 'l') {
      document.getElementById('admin-login-btn').style.display = 'block';
    }
  });
  </script>
</body>

</html>