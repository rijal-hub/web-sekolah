<?php
// Menyertakan file koneksi database
include('config/db_connect.php');

// Menangkap parameter filter kategori
$filter = isset($_GET['filter']) ? $_GET['filter'] : '*';
$id = isset($_GET['id']) ? $_GET['id'] : null; // Tangkap ID gambar jika ada

// Menentukan query berdasarkan kategori yang dipilih
if ($filter == '*') {
    // Jika tidak ada filter, tampilkan semua data
    $query = "SELECT nama_prestasi, foto, deskripsi, kategori FROM prestasi_sekolah";
    $result = $conn->query($query); // Jika query biasa
} else {
    // Jika filter akademik dipilih, tampilkan data dengan kategori akademik
    $query = $conn->prepare("SELECT nama_prestasi, foto, deskripsi, kategori FROM prestasi_sekolah WHERE kategori = ?");
    $query->bind_param("s", $filter);  // "s" berarti string
    $query->execute();
    $result = $query->get_result(); // Dapatkan hasil query
}
$sql = "SELECT nama_web, link FROM website";
$result_website = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Prestasi Sekolah</title>
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

<body class="portfolio-page">

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
              <li><a href="team.php"> Profil Guru</a></li>
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
        <h1 class="mb-2 mb-lg-0">PRESTASI SEKOLAH</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">BERANDA</a></li>
            <li class="current">PRESTASI SEKOLAH</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

  <!-- Portfolio Section -->
<section id="portfolio" class="portfolio section">
    <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
        <ul class="portfolio-filters" data-aos="fade-up" data-aos-delay="100">
  <li id="all" data-filter="*" class="<?= $filter == '*' || $filter == '' ? 'filter-active' : '' ?>" onclick="switchTab(this, 'all-container')">
    <a href="?filter=*">Semua</a>
  </li>
  <li id="akademik" data-filter=".filter-akademik" class="<?= $filter == 'akademik' ? 'filter-active' : '' ?>" onclick="switchTab(this, 'akademik-container')">
    <a href="?filter=akademik">Akademik</a>
  </li>
  <li id="non-akademik" data-filter=".filter-non-akademik" class="<?= $filter == 'non-akademik' ? 'filter-active' : '' ?>" onclick="switchTab(this, 'non-akademik-container')">
    <a href="?filter=non-akademik">Non-Akademik</a>
  </li>
</ul>

<div id="all-container" class="content-container" style="display:block;">
    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        <?php
        // Menampilkan data dari database untuk Semua
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-lg-4 col-md-6 portfolio-item isotope-item">
            <img src="admin/prestasi_sekolah/uploads/<?php echo $row['foto']; ?>" class="img-fluid" alt="">
            <div class="portfolio-info">
                <h4><?php echo $row['nama_prestasi']; ?></h4>
                <a href="admin/prestasi_sekolah/uploads/<?php echo $row['foto']; ?>" title="<?php echo $row['deskripsi']; ?>" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
            </div>
        </div><!-- End Portfolio Item -->
        <?php
            }
        } else {
            echo "Data tidak ditemukan.";
        }
        ?>
    </div>
</div><!-- End All Container -->

<div id="akademik-container" class="content-container" style="display:none;">
    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        <?php
        // Menampilkan data untuk kategori akademik
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['kategori'] == 'akademik') {
        ?>
        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-akademik">
            <img src="admin/prestasi_sekolah/uploads/<?php echo $row['foto']; ?>" class="img-fluid" alt="">
            <div class="portfolio-info">
                <h4><?php echo $row['nama_prestasi']; ?></h4>
                <a href="admin/prestasi_sekolah/uploads/<?php echo $row['foto']; ?>" title="<?php echo $row['deskripsi']; ?>" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
            </div>
        </div><!-- End Portfolio Item -->
        <?php
                }
            }
        } else {
            echo "Data tidak ditemukan.";
        }
        ?>
    </div>
</div><!-- End Akademik Container -->

<div id="non-akademik-container" class="content-container" style="display:none;">
    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        <?php
        // Menampilkan data untuk kategori non-akademik
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['kategori'] == 'non-akademik') {
        ?>
        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-non-akademik">
            <img src="admin/prestasi_sekolah/uploads/<?php echo $row['foto']; ?>" class="img-fluid" alt="">
            <div class="portfolio-info">
                <h4><?php echo $row['nama_prestasi']; ?></h4>
                <a href="admin/prestasi_sekolah/uploads/<?php echo $row['foto']; ?>" title="<?php echo $row['deskripsi']; ?>" data-gallery="portfolio-gallery-product" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
            </div>
        </div><!-- End Portfolio Item -->
        <?php
                }
            }
        } else {
            echo "Data tidak ditemukan.";
        }
        ?>
    </div>
</div><!-- End Non-Akademik Container -->

<script>
function switchTab(element, containerId) {
    // Menyembunyikan semua kontainer
    var containers = document.querySelectorAll('.content-container');
    containers.forEach(function(container) {
        container.style.display = 'none';
    });

    // Menonaktifkan semua tombol filter
    var options = document.querySelectorAll('.portfolio-filters li');
    options.forEach(function(option) {
        option.classList.remove('filter-active');
    });

    // Menampilkan kontainer yang dipilih
    document.getElementById(containerId).style.display = 'block';

    // Menandai tombol yang aktif
    element.classList.add('filter-active');
}
</script>

  </main>
  <?php
$kontak = [
  'alamat' => 'Jl. Sedayu Sawo Raya No.1, Bangetayu Wetan, Kec. Genuk, Kota Semarang, Jawa Tengah 50115',
  'telp' => '(024) 76451362',
  'email' => 'sdnbangetayuwetan34@yahoo.co.id'
];
?>

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <h4>Alamat</h4>
        <p>Jl. Sedayu Sawo Raya No.1, Bangetayu Wetan, Kec. Genuk, Kota Semarang, Jawa Tengah 50115</p>
        <p class="mt-3"><strong> Nomor telp:</strong> <span>(024) 76451362</span></p>
        <p><strong>Email:</strong> <span>sdnbangetayuwetan34@yahoo.co.id</span></p>
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
  <script>function switchTab(element, containerId) {
    // Menyembunyikan semua kontainer
    var containers = document.querySelectorAll('.content-container');
    containers.forEach(function(container) {
        container.style.display = 'none';
    });

    // Menonaktifkan semua tombol
    var options = document.querySelectorAll('.portfolio-filters li');
    options.forEach(function(option) {
        option.classList.remove('filter-active');
    });

    // Menampilkan kontainer yang dipilih
    document.getElementById(containerId).style.display = 'block';

    // Menandai tombol yang aktif
    element.classList.add('filter-active');
}

</script>
  
<script>
  document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key.toLowerCase() === 'l') {
      document.getElementById('admin-login-btn').style.display = 'block';
    }
  });
</script>

</body>

</html>