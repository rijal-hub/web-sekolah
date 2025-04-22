<?php
// Menyertakan file koneksi database
include('config/db_connect.php');

// Menangkap ID berita dari URL dan validasi
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;

if (!$id) {
    die("ID berita tidak valid.");
}

// Query untuk mengambil data berita
$query = "SELECT judul, media, isi, kategori FROM berita_sekolah WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Berita tidak ditemukan.");
}

$berita = $result->fetch_assoc();
$judul = $berita['judul'];
$media = $berita['media'];
$isi = $berita['isi'];
$kategori = $berita['kategori'];

// Query terpisah untuk data kontak (jika diperlukan)
$query_kontak = "SELECT * FROM kontak LIMIT 1"; // Ambil satu data kontak saja
$result_kontak = $conn->query($query_kontak);
$kontak = $result_kontak->fetch_assoc();
$sql = "SELECT nama_web, link FROM website";
$result_website = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Detail Warta</title>
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

<body class="portfolio-details-page">

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
          <li class="dropdown">
            <a href="javascript:void(0)"> <span>website terkait</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <?php
              // Cek jika data ada
              if ($result_website->num_rows > 0) {
                  // Tampilkan setiap baris data sebagai item dropdown
                  while($row = $result_website->fetch_assoc()) {
                      echo '<li><a href="' . $row['link'] . '">' . $row['nama_web'] . '</a></li>';
                  }
              } else {
                  echo '<li><a href="#">Tidak ada data</a></li>';
              }
              ?>
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

    <!-- Page Title -->
    <div class="page-title accent-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Portfolio Details</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Portfolio Details</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
     <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">
      <div class="container" data-aos="fade-up">
        <div class="portfolio-details-slider swiper init-swiper">
          <!-- Konfigurasi swiper -->
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide">
              <?php if (filter_var($media, FILTER_VALIDATE_URL)): ?>
                <iframe width="100%" height="500" src="<?= htmlspecialchars($media) ?>" frameborder="0" allowfullscreen></iframe>
              <?php else: ?>
                <img src="admin/berita_sekolah/uploads/<?= htmlspecialchars($media) ?>" class="img-fluid" alt="<?= htmlspecialchars($judul) ?>">
              <?php endif; ?>
            </div>
          </div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-pagination"></div>
        </div>

        <div class="row justify-content-between gy-4 mt-4">
          <div class="col-lg-8" data-aos="fade-up">
            <div class="portfolio-description">
              <h2><?= htmlspecialchars($judul) ?></h2>
              <p><?= nl2br(htmlspecialchars($isi)) ?></p>
            </div>
          </div>
          
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="portfolio-info">
              <h3>Informasi Warta</h3>
              <ul>
                <li><strong>Kategori</strong>: <?= htmlspecialchars($kategori) ?></li>
                <li><strong>Tanggal Publikasi</strong>: <?= date('d F Y') ?></li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="container mt-5">
          <div class="d-flex justify-content-end">
            <a href="javascript:history.back()" class="btn px-4 py-2 rounded-pill" style="background-color: #4a4c58; color: white;">
              <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>


  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <h4>Alamat</h4>
        <p><?= $kontak['alamat']; ?></p>
        <p class="mt-3"><strong> Nomor telp:</strong> <span><?= $kontak['telp']; ?></span></p>
        <p><strong>Email:</strong> <span><?= $kontak['email']; ?></span></p>
      </div>
      <div class="col-lg-3 col-md-6  align-items-center footer-links">
    <h4>Tautan</h4>
    <ul>
        <li><a href="https://www.kemdikbud.go.id/">Kemendikbud</a></li>
        <li><a href="https://disdiksmg.semarangkota.go.id/">Dinas Pendidikan</a></li>
    </ul>
    <div class="social-links d-flex mt-4">
        <!-- Tampilkan link sosial media secara dinamis -->
        <?php if (!empty($kontak['facebook'])): ?>
            <a href="<?php echo $kontak['facebook']; ?>"><i class="bi bi-facebook"></i></a>
        <?php endif; ?>
        <?php if (!empty($kontak['instagram'])): ?>
            <a href="<?php echo $kontak['instagram']; ?>"><i class="bi bi-instagram"></i></a>
        <?php endif; ?>
        <?php if (!empty($kontak['youtube'])): ?>
            <a href="<?php echo $kontak['youtube']; ?>"><i class="bi bi-youtube"></i></a>
        <?php endif; ?>
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