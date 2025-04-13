<?php
// Include file db_connect.php untuk koneksi ke database
include 'config/db_connect.php';

// Query untuk mengambil semua data dari tabel profil_guru
$query = "SELECT * FROM profil_karyawan";
$result = $conn->query($query);

// Cek apakah data ditemukan
if (!$result || $result->num_rows === 0) {
    echo "Tidak ada data karyawan yang ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Team - Company Bootstrap Template</title>
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

<body class="team-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    
    <div class="container position-relative d-flex ">

      <a href="index.html" class="logo d-flex align-items-center me-auto">

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
              <li><a href="karyawan.php"  class="active">Daftar Karyawan</a></li>
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
          <li><a href="login.php" class="login-box">Login</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title accent-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Daftar Karyawan</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">BERANDA</a></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Team Section -->
    <section id="team" class="team section">

      <div class="container">

      <div class="row gy-4">
  <?php
  // Menampilkan data dari database
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
  ?>
   <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
  <div class="team-member">
    <div class="member-img" 
         style="background-image: url('admin/profil_karyawan/uploads/<?php echo htmlspecialchars($row['foto']); ?>'); 
                background-size: cover; 
                background-position: center; 
                width: 100%; 
                height: 250px; 
                margin-bottom: 20px;">
      <!-- No need for <img> tag here -->
    </div>
    <div class="member-info">
      <h4><?php echo htmlspecialchars($row['nama']); ?></h4>
      <span><?php echo htmlspecialchars($row['jabatan']); ?></span>
    </div>
  </div>
</div><!-- End Team Member -->

  <?php
      }
  } else {
      echo "<p>Tidak ada data guru yang ditemukan.</p>";
  }
  ?>
</div> <!-- tutup row gy-4 -->
        </div>

      </div>

    </section><!-- /Team Section -->

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
        <p><?= $kontak['alamat']; ?></p>
        <p class="mt-3"><strong> Nomor telp:</strong> <span><?= $kontak['telp']; ?></span></p>
        <p><strong>Email:</strong> <span><?= $kontak['email']; ?></span></p>
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
          <a href="contact.html" class="btn btn-dark">Berikan Umpan Balik</a>

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

</body>

</html>
