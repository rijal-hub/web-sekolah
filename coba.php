<?php
include 'config/db_connect.php';       // koneksi database
include 'tambah_adu.php';      // fungsi pengaduan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap input dari form
    $nama       = htmlspecialchars(trim($_POST['nama']));
    $no_kontak  = htmlspecialchars(trim($_POST['no_kontak']));
    $email      = htmlspecialchars(trim($_POST['email']));
    $deskripsi  = htmlspecialchars(trim($_POST['deskripsi']));

    // Validasi dasar (boleh dikembangkan lagi)
    if (empty($nama) || empty($no_kontak) || empty($email) || empty($deskripsi)) {
        echo "<script>alert('Semua field harus diisi.'); window.location.href='contact.php';</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid.'); window.location.href='contact.php';</script>";
        exit;
    }

    // Kirim pengaduan
    $hasil = kirimPengaduan($conn, $nama, $no_kontak, $email, $deskripsi);

    // Tampilkan pesan hasil
    if ($hasil['status']) {
        echo "<script>alert('{$hasil['message']}'); window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pengaduan: {$hasil['message']}'); window.location.href='contact.php';</script>";
    }
}

$id = 1;

// Query untuk mengambil data beranda berdasarkan id = 1
$query = "SELECT * FROM kontak WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $kontak = $result->fetch_assoc();
} else {
    echo "Data beranda tidak ditemukan.";
    exit;
}
$sql = "SELECT nama_web, link FROM website";
$result_website = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact - Company Bootstrap Template</title>
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

<body class="contact-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    
    <div class="container position-relative d-flex ">

      <a href="index.php" class="logo d-flex align-items-center me-auto">

      <img src="aset/logo sd.png" alt="Logo SD" class="logo-img">
        <h1 class="sitename">SDN BANGETAYU WETAN 02</h1>
      </a>
      </nav><nav id="navmenu" class="navmenu">
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
        <h1 class="mb-2 mb-lg-0">KONTAK</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">BERANDA</a></li>
            <li class="current">KONTAK</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="mb-5">
        <iframe style="width: 100%; height: 500px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1980.1144752355945!2d110.485692!3d-6.982287!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708d2561b465cf%3A0x6f662c788b510805!2sSD%20Negeri%20Bangetayu%20Wetan%2002!5e0!3m2!1sid!2sid!4v1742620235937!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" allowfullscreen=""></iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade">

        <div class="row gy-5 gx-lg-5">

          <div class="col-lg-4">

            <div class="info">
              <h3>Kontak Kami</h3>
              <p>Silahkan hubungi kami atau tinggalkan kritik, sara, atau pengaduan Anda pada formulir berikut.</p>

              <div class="info-item d-flex">
  <i class="bi bi-geo-alt flex-shrink-0"></i>
  <div>
    <h4>Location:</h4>
    <p><?php echo nl2br(htmlspecialchars($kontak['alamat'])); ?></p>
  </div>
</div><!-- End Info Item -->

<div class="info-item d-flex">
  <i class="bi bi-envelope flex-shrink-0"></i>
  <div>
    <h4>Email:</h4>
    <p><?php echo nl2br(htmlspecialchars($kontak['email'])); ?></p>
  </div>
</div><!-- End Info Item -->

<div class="info-item d-flex">
  <i class="bi bi-phone flex-shrink-0"></i>
  <div>
    <h4>Telepon:</h4>
    <p><?php echo nl2br(htmlspecialchars($kontak['telepon'])); ?></p>
  </div>
</div><!-- End Info Item -->
            </div>

          </div>

          <div class="col-lg-8">
          <div class="col-lg-8">
  <!-- Ganti form PHP dengan Google Form -->
  <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeedVbbOPUDCunCE6Q5t5FSiOgd8f2nE97tuYIuqtp3unu1wg/viewform?embedded=true" width="640" height="454" frameborder="0" marginheight="0" marginwidth="0">Memuat…</iframe>
</div>





            </div>
        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

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