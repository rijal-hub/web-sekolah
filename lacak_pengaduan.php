<?php
include 'config/db_connect.php';

$no_tiket = '';
$pengaduan = null;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_tiket = htmlspecialchars(trim($_POST['no_tiket']));
    
    $stmt = $conn->prepare("SELECT * FROM pengaduan WHERE no_tiket = ?");
    $stmt->bind_param("s", $no_tiket);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $pengaduan = $result->fetch_assoc();
    } else {
        $error = "Pengaduan dengan nomor tiket tersebut tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Sertakan bagian head yang sama seperti di contact.php -->
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Lomba-Lomba</title>
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
</head>
<body>
    <!-- Header yang sama seperti di contact.php -->

    <main class="main">
  <div class="page-title accent-background py-4">
    <div class="container">
      <h1 class="text-white text-center">LACAK PENGADUAN</h1>
    </div>
  </div>

  <section class="section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">Cek Status Pengaduan</h3>

              <form method="POST" action="lacak_pengaduan.php">
                <div class="form-group mb-3">
                  <label for="no_tiket">Masukkan Nomor Tiket</label>
                  <input type="text" class="form-control" id="no_tiket" name="no_tiket" required placeholder="Contoh: TKT123456">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Cek Status</button>
                </div>
              </form>

              <?php if ($error): ?>
                <div class="alert alert-danger mt-4"><?= $error ?></div>
              <?php endif; ?>

              <?php if ($pengaduan): ?>
              <div class="mt-5">
                <h4 class="mb-3">Detail Pengaduan</h4>
                <table class="table table-bordered">
                  <tr>
                    <th>Nomor Tiket</th>
                    <td><?= htmlspecialchars($pengaduan['no_tiket']) ?></td>
                  </tr>
                  <tr>
                    <th>Nama</th>
                    <td><?= htmlspecialchars($pengaduan['nama']) ?></td>
                  </tr>
                  <tr>
                    <th>Tanggal</th>
                    <td><?= date('d/m/Y H:i', strtotime($pengaduan['tanggal'])) ?></td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td>
                      <?php 
                        $status_class = match($pengaduan['status']) {
                          'belum diproses' => 'badge bg-warning text-dark',
                          'diproses' => 'badge bg-primary',
                          'selesai' => 'badge bg-success',
                          default => 'badge bg-secondary'
                        };
                      ?>
                      <span class="<?= $status_class ?>"><?= strtoupper($pengaduan['status']) ?></span>
                    </td>
                  </tr>
                  <tr>
                    <th>Deskripsi</th>
                    <td><?= nl2br(htmlspecialchars($pengaduan['deskripsi'])) ?></td>
                  </tr>
                </table>

                <div class="mt-4">
                  <label class="mb-1 fw-semibold">Progress Penanganan</label>
                  <?php 
                    $progress = match($pengaduan['status']) {
                      'diproses' => 50,
                      'selesai' => 100,
                      default => 10
                    };
                  ?>
                  <div class="progress">
                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" 
                         role="progressbar" style="width: <?= $progress ?>%" 
                         aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                      <?= $progress ?>%
                    </div>
                  </div>
                </div>
              </div>
              <?php endif; ?>

            </div>
            
          </div>
        </div>
        <div class="d-flex justify-content-end">
            <a href="javascript:history.back()" class="btn px-4 py-2 rounded-pill" style="background-color: #4a4c58; color: white;">
              <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
          </div>
      </div>
    </div>
  </section>
</main>

