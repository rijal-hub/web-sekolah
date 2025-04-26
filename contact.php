<?php
include 'config/db_connect.php';       // Database connection
include 'tambah_adu.php';              // Include complaint function

$modalMessage = '';  // Variable to hold modal message
$modalTitle = '';    // Variable to hold modal title
$showModal = false;  // Flag to show modal

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture input from the form
    $nama       = htmlspecialchars(trim($_POST['nama']));
    $no_kontak  = htmlspecialchars(trim($_POST['no_kontak']));
    $email      = htmlspecialchars(trim($_POST['email']));
    $deskripsi  = htmlspecialchars(trim($_POST['deskripsi']));

    // Basic validation (can be further developed)
    if (empty($nama) || empty($no_kontak) || empty($email) || empty($deskripsi)) {
        $modalMessage = 'Seluruh kolom harus terisi.';
        $modalTitle = 'Gagal';
        $showModal = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $modalMessage = 'Email tidak valid.';
        $modalTitle = 'Gagal';
        $showModal = true;
    } else {
        // Submit complaint to the database
        $hasil = kirimPengaduan($conn, $nama, $no_kontak, $email, $deskripsi);

        // Show result message
        if ($hasil['status']) {
            $modalMessage = $hasil['message'];
            $modalTitle = 'Berhasil';
            $showModal = true;
        } else {
            $modalMessage = 'Gagal mengirim pengaduan ' . $hasil['message'];
            $modalTitle = 'Gagal';
            $showModal = true;
        }
    }
}

// Fetch the contact information (one record)
$query_kontak = "SELECT * FROM kontak LIMIT 1";
$result_kontak = $conn->query($query_kontak);
$kontak = $result_kontak->fetch_assoc();

// Fetch related website links
$sql = "SELECT nama_web, link FROM website";
$result_website = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Kontak - SDN Bangetayu Wetan 02</title>
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
  <!-- Include jsPDF library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
        <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1980.1144752355945!2d110.485692!3d-6.982287!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708d2561b465cf%3A0x6f662c788b510805!2sSD%20Negeri%20Bangetayu%20Wetan%2002!5e0!3m2!1sid!2sid!4v1742620235937!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" allowfullscreen=""></iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade">

        <div class="row gy-5 gx-lg-5">

          <div class="col-lg-4">

            <div class="info">
              <h3>Kontak Kami</h3>
              <p>Silahkan tinggalkan pesan Anda pada kolom yang tersedia</p>

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
          <form action="contact.php" method="POST" role="form" class="php-email-form">
  <div class="row">
    <div class="form-group mt-3">
      <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama Anda" required="">
    </div>
    <div class="col-md-6 form-group">
      <input type="text" name="no_kontak" class="form-control" id="no_kontak" placeholder="Masukkan No.Telepon Anda" required="">
    </div>
    <div class="col-md-6 form-group">
      <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email Anda" required="">
    </div>
    <div class="form-group mt-3">
      <textarea class="form-control" name="deskripsi" placeholder="Tuliskan pengaduan Anda" required=""></textarea>
    </div>
  </div>
  <div class="text-center"><button type="submit">Kirim Pengaduan</button></div>
</form>
<!-- Di bagian footer atau di halaman contact -->
<div class="text-center mt-3">
    <p>Ingin melacak pengaduan Anda? <a href="lacak_pengaduan.php"><b>Klik di sini</b></a></p>
</div>



            </div>
        </div>

      </div>

    </section><!-- /Contact Section -->
<!-- Modal for Success or Error message -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">Pengaduan Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalMessageBody">
        <!-- Dynamic message will be displayed here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="downloadProofBtn">Unduh Bukti</button>
      </div>
    </div>
  </div>
</div>


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
<script>
    <?php if ($showModal): ?>
      document.addEventListener('DOMContentLoaded', function() {
    var modalMessage = "<?php echo addslashes($modalMessage); ?>";
    var modalTitle = "<?php echo addslashes($modalTitle); ?>";

    // Update modal content
    document.getElementById('modalMessageBody').innerText = modalMessage;
    document.getElementById('messageModalLabel').innerText = modalTitle;

    // Show modal
    var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    messageModal.show();

    // Add event listener for download button
    document.getElementById('downloadProofBtn').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Set PDF properties (fonts, title, etc.)
        doc.setFont("helvetica");
        doc.setFontSize(12);
        doc.setTextColor(0, 0, 0); // Set text color to black

        // Title with bold and large font
        doc.setFontSize(16);
        doc.setFont("helvetica", "bold");
        doc.text("DETAIL PENGADUAN", 105, 20, { align: 'center' }); // Centered title

        // Add a line separator
        doc.setLineWidth(0.5);
        doc.line(10, 25, 200, 25); // Horizontal line

        // Content text - "Terima kasih atas pengaduan..."
        doc.setFontSize(12);
        doc.setFont("helvetica", "normal");
        var messageText = "Terima kasih atas pengaduan yang telah Anda kirimkan. Berikut adalah rincian pengaduan Anda:";
        var splitText = doc.splitTextToSize(messageText, 180);
        doc.text(splitText, 10, 40);
        
        let yPos = 40 + (splitText.length * 6); // Update the y position after the message

        // User Info Section
        doc.setFont("helvetica", "bold");
        doc.text("Nama:", 10, yPos);
        doc.setFont("helvetica", "normal");
        var namaText = "<?php echo addslashes($nama); ?>";
        var splitNama = doc.splitTextToSize(namaText, 150);
        doc.text(splitNama, 50, yPos);
        yPos += (splitNama.length * 6);

        doc.setFont("helvetica", "bold");
        doc.text("No. Telepon:", 10, yPos);
        doc.setFont("helvetica", "normal");
        var noTeleponText = "<?php echo addslashes($no_kontak); ?>";
        var splitNoTelepon = doc.splitTextToSize(noTeleponText, 150);
        doc.text(splitNoTelepon, 50, yPos);
        yPos += (splitNoTelepon.length * 6);

        doc.setFont("helvetica", "bold");
        doc.text("Email:", 10, yPos);
        doc.setFont("helvetica", "normal");
        var emailText = "<?php echo addslashes($email); ?>";
        var splitEmail = doc.splitTextToSize(emailText, 150);
        doc.text(splitEmail, 50, yPos);
        yPos += (splitEmail.length * 6);

        doc.setFont("helvetica", "bold");
        doc.text("Pesan:", 10, yPos);
        doc.setFont("helvetica", "normal");
        var deskripsiText = "<?php echo addslashes($deskripsi); ?>";
        var splitDeskripsi = doc.splitTextToSize(deskripsiText, 150);
        doc.text(splitDeskripsi, 50, yPos);
        yPos += (splitDeskripsi.length * 6);

        yPos += 10; // Add space after the line

        // Tanggal and Tiket Section
        doc.setFont("helvetica", "bold");
        doc.text("Tanggal:", 10, yPos);
        doc.setFont("helvetica", "normal");
        var tanggalText = "<?php echo addslashes($hasil['tanggal']); ?>";
        var splitTanggal = doc.splitTextToSize(tanggalText, 150);
        doc.text(splitTanggal, 50, yPos);
        yPos += (splitTanggal.length * 6);

        doc.setFont("helvetica", "bold");
        doc.text("No. Tiket:", 10, yPos);
        doc.setFont("helvetica", "normal");
        var tiketText = "<?php echo addslashes($hasil['no_tiket']); ?>";
        var splitTiket = doc.splitTextToSize(tiketText, 150);
        doc.text(splitTiket, 50, yPos);
        yPos += (splitTiket.length * 6);

      
        yPos += 10; // Add space after the line

        // Follow-up message
        doc.setFont("helvetica", "normal");
        var followUpText = "Kami akan segera menindaklanjuti pengaduan Anda dan berusaha memberikan solusi terbaik.";
        var splitFollowUp = doc.splitTextToSize(followUpText, 180);
        doc.text(splitFollowUp, 10, yPos);
        yPos += (splitFollowUp.length * 6);

        var progressText = "Untuk memantau progres pengaduan, Anda dapat melacak kode tiket melalui website kami.";
        var splitProgress = doc.splitTextToSize(progressText, 180);
        doc.text(splitProgress, 10, yPos);
        yPos += (splitProgress.length * 6);

        
        yPos += 10; // Add space after the line

        var thankYouText = "Terima kasih atas perhatian dan kerjasama Anda.";
        var splitThankYou = doc.splitTextToSize(thankYouText, 180);
        doc.text(splitThankYou, 10, yPos);
        yPos += (splitThankYou.length * 6);

        
        yPos += 10; // Add space after the line

        // Add closing remark
        doc.setFont("helvetica", "bold");
        doc.text("Salam Hormat,", 10, yPos);
        yPos += 10;
        doc.setFont("helvetica", "normal");
        doc.text("SDN Bangetayu Wetan 02", 10, yPos);

        // Save the PDF
        doc.save("Pengaduan_<?php echo $nama; ?>.pdf");
    });
});

    <?php endif; ?>
</script>

</body>
</html>

</body>

</html>