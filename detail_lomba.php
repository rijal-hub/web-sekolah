<?php
// Mengambil nilai 'jenis_lomba' dari URL (misalnya: http://localhost/web-sekolah/detail_lomba.php?jenis_lomba=video)
$jenis_lomba_filter = isset($_GET['jenis_lomba']) ? $_GET['jenis_lomba'] : '';

// Mengambil data lomba dari database
include('config/db_connect.php');

// Mengambil nilai filter 'jenis_lomba' dan 'filter' dari URL
$jenis_lomba_filter = isset($_GET['jenis_lomba']) ? $_GET['jenis_lomba'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Mengambil data lomba dari database
include('config/db_connect.php');

// Menyesuaikan query SQL berdasarkan jenis_lomba dan filter
if ($jenis_lomba_filter != '') {
    if ($filter != '') {
        // Jika ada filter jenis_lomba dan filter, sesuaikan query SQL
        $sql = "SELECT * FROM lomba_lomba WHERE jenis_lomba = '{$jenis_lomba_filter}' AND jenis_media = '{$filter}'";
    } else {
        // Jika hanya ada filter jenis_lomba
        $sql = "SELECT * FROM lomba_lomba WHERE jenis_lomba = '{$jenis_lomba_filter}'";
    }
} else {
    // Jika tidak ada filter jenis_lomba
    if ($filter != '') {
        // Jika hanya ada filter jenis_media (foto atau video)
        $sql = "SELECT * FROM lomba_lomba WHERE jenis_media = '{$filter}'";
    } else {
        // Jika tidak ada filter sama sekali
        $sql = "SELECT * FROM lomba_lomba";
    }
}

$result = $conn->query($sql);


// Menginisialisasi array untuk setiap kategori
$all_items = [];
$foto_items = [];
$video_items = [];

if ($result->num_rows > 0) {
    while ($lomba = $result->fetch_assoc()) {
        $media = $lomba['media'];
        $nama_lomba = $lomba['nama_lomba'];
        $jenis_lomba = $lomba['jenis_lomba'];

        // Mengecek apakah media berupa URL (gambar atau video)
        if (filter_var($media, FILTER_VALIDATE_URL)) {
            // Jika media berupa URL video (YouTube atau youtu.be)
            if (strpos($media, 'youtube') !== false || strpos($media, 'youtu.be') !== false) {
                // Cek apakah URLnya dari youtu.be
                if (strpos($media, 'youtu.be') !== false) {
                    // Mengambil ID video dari URL youtu.be
                    preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $media, $matches);
                    $video_id = $matches[1]; // ID video
                } else {
                    // Jika URL dari youtube.com, ambil ID video setelah 'v='
                    parse_str(parse_url($media, PHP_URL_QUERY), $url_params);
                    $video_id = $url_params['v']; // ID video
                }

                // Membuat URL embed
                $embed_url = "https://www.youtube.com/embed/{$video_id}";
                $video_items[] = [
                    'id' => $lomba['id'],
                    'nama_lomba' => $nama_lomba,
                    'embed_url' => $embed_url,
                    'video_id' => $video_id
                ];
            } else {
                // Jika media adalah URL selain video (misalnya link gambar eksternal)
                $foto_items[] = [
                    'id' => $lomba['id'],
                    'nama_lomba' => $nama_lomba,
                    'media' => $media
                ];
            }
        } else {
            // Jika media adalah file gambar
            $foto_items[] = [
                'id' => $lomba['id'],
                'nama_lomba' => $nama_lomba,
                'media' => "admin/lomba_sekolah/uploads/{$media}"
            ];
        }
    }
} else {
    echo "Tidak ada data lomba ditemukan";
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

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Lomba Lomba</title>
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

<body class="services-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    
    <div class="container position-relative d-flex ">

      <a href="index.html" class="logo d-flex align-items-center me-auto">

      <img src="aset/logo sd.png" alt="Logo SD" class="logo-img">
        <h1 class="sitename">SDN BANGETAYU WETAN 02</h1>
      </a>
      <na id="navmenu" class="navmenu">
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
        <h1 class="mb-2 mb-lg-0">Lomba-Lomba</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Lomba-Lomba</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

   

    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up" style="margin-bottom:-45px;" >
        <h2>Galeri Lomba</h2>
        <p>Berikut merupakan dokumentasi lomba yang diikuti siswa SDN Bangetayu Wetan 02</p>
      </div><!-- End Section Title --><section id="portfolio" class="portfolio section">
    <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
            <ul class="portfolio-filters">
                <li class="<?= !isset($_GET['filter']) || $_GET['filter'] == '' ? 'filter-active' : '' ?>">
                    <a href="?filter=&jenis_lomba=<?= isset($_GET['jenis_lomba']) ? $_GET['jenis_lomba'] : '' ?>">Semua</a>
                </li>
                <li class="<?= isset($_GET['filter']) && $_GET['filter'] == 'foto' ? 'filter-active' : '' ?>">
                    <a href="?filter=foto&jenis_lomba=<?= isset($_GET['jenis_lomba']) ? $_GET['jenis_lomba'] : '' ?>" id="filter-foto">Foto</a>
                </li>
                <li class="<?= isset($_GET['filter']) && $_GET['filter'] == 'video' ? 'filter-active' : '' ?>">
                    <a href="?filter=video&jenis_lomba=<?= isset($_GET['jenis_lomba']) ? $_GET['jenis_lomba'] : '' ?>" id="filter-video">Video</a>
                </li>
            </ul>
            <div id="all-container" class="content-container" style="display:block;">
                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    <?php
                    // Mengambil nilai 'filter' dan 'jenis_lomba' dari URL
                    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
                    $jenis_lomba_filter = isset($_GET['jenis_lomba']) ? $_GET['jenis_lomba'] : '';

                    // Menyusun query SQL berdasarkan filter
                    include('config/db_connect.php');

                    // Menyesuaikan query SQL berdasarkan filter dan jenis_lomba
                    $sql = "SELECT * FROM lomba_lomba WHERE 1";
                    if ($jenis_lomba_filter != '') {
                      if ($filter != '') {
                          $sql = "SELECT * FROM lomba_lomba WHERE jenis_lomba = ? AND jenis_media = ?";
                          $stmt = $conn->prepare($sql);
                          $stmt->bind_param('ss', $jenis_lomba_filter, $filter);
                      } else {
                          $sql = "SELECT * FROM lomba_lomba WHERE jenis_lomba = ?";
                          $stmt = $conn->prepare($sql);
                          $stmt->bind_param('s', $jenis_lomba_filter);
                      }
                  } else {
                      if ($filter != '') {
                          $sql = "SELECT * FROM lomba_lomba WHERE jenis_media = ?";
                          $stmt = $conn->prepare($sql);
                          $stmt->bind_param('s', $filter);
                      } else {
                          $sql = "SELECT * FROM lomba_lomba";
                          $stmt = $conn->prepare($sql);
                      }
                  }
                  
                  $stmt->execute();
                  $result = $stmt->get_result();
                  
                    if ($result->num_rows > 0) {
                        while ($lomba = $result->fetch_assoc()) {
                            $media = $lomba['media'];
                            $nama_lomba = $lomba['nama_lomba'];
                            $deskripsi = $lomba['deskripsi'];
                            $jenis_lomba = $lomba['jenis_lomba'];

                            // Mengecek apakah media berupa URL (gambar atau video)
                            if (filter_var($media, FILTER_VALIDATE_URL)) {
                                // Jika media berupa URL video (YouTube atau youtu.be)
                                if (strpos($media, 'youtube') !== false || strpos($media, 'youtu.be') !== false) {
                                    // Cek apakah URLnya dari youtu.be
                                    if (strpos($media, 'youtu.be') !== false) {
                                        // Mengambil ID video dari URL youtu.be
                                        preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $media, $matches);
                                        $video_id = $matches[1]; // ID video
                                    } else {
                                        // Jika URL dari youtube.com, ambil ID video setelah 'v='
                                        parse_str(parse_url($media, PHP_URL_QUERY), $url_params);
                                        $video_id = $url_params['v']; // ID video
                                    }

                                    // Membuat URL embed
                                    $embed_url = "https://www.youtube.com/embed/{$video_id}";
                                    ?>
                                    <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-<?php echo $jenis_lomba; ?>">
                                        <div class="portfolio-video">
                                            <!-- Iframe Video (Disembunyikan Awal) -->
                                            <iframe 
                                                id="video-iframe-<?php echo $lomba['id']; ?>"
                                                width="100%" 
                                                height="200" 
                                                src="https://www.youtube.com/embed/<?php echo $video_id; ?>?autoplay=1" 
                                                title="<?php echo $nama_lomba; ?>" 
                                                frameborder="0" 
                                                allowfullscreen 
                                                style="display: block;">
                                            </iframe>
                                        </div>
                                        <div class="portfolio-info">
                                            <h4><?php echo $nama_lomba; ?></h4>
                                            <a href="https://youtu.be/<?php echo $video_id; ?>" title="Tonton Video" target="_blank" class="preview-link">
                                                <i class="bi bi-play-circle"></i>
                                            </a>
                                        </div>
                                    </div><!-- End Portfolio Item -->
                                    <?php
                                }
                            } else {
                                // Jika media adalah gambar
                                ?>
                                <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-<?php echo $jenis_lomba; ?>">
                                    <img src="admin/lomba_sekolah/uploads/<?php echo $media; ?>" class="img-fluid" alt="<?php echo $nama_lomba; ?>">
                                    <div class="portfolio-info">
                                        <h4><?php echo $nama_lomba; ?></h4>
                                        <a href="admin/lomba_sekolah/uploads/<?php echo $media; ?>" title="<?php echo $deskripsi; ?>"class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                                    </div>
                                </div><!-- End Portfolio Item -->
                                <?php
                            }
                        }
                    } else {
                        echo "Tidak ada data lomba ditemukan";
                    }

                    // Menutup koneksi
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


        </div>

      </div>

    </section><!-- /Features Section -->

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
  <script>
    // Fungsi untuk menampilkan kontainer yang sesuai berdasarkan filter
    function filterMedia(mediaType) {
        // Sembunyikan kedua kontainer
        document.getElementById('foto-container').style.display = 'none';
        document.getElementById('video-container').style.display = 'none';
        
        // Tampilkan kontainer yang sesuai berdasarkan filter
        if (mediaType === 'foto') {
            document.getElementById('foto-container').style.display = 'block';
        } else if (mediaType === 'video') {
            document.getElementById('video-container').style.display = 'block';
        } else {
            document.getElementById('foto-container').style.display = 'block';
            document.getElementById('video-container').style.display = 'block';
        }
    }

    // Cek status filter saat halaman dimuat
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter'); // Ambil nilai filter dari URL
        
        // Panggil fungsi filterMedia berdasarkan nilai filter di URL
        filterMedia(filter);
    };
</script>


</body>

</html>