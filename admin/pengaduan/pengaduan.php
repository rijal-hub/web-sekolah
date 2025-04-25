<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

// Include file db_connect.php untuk koneksi ke database
include 'db_connect.php';

// Update status jika ada request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE pengaduan SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    
    header("Location: pengaduan.php");
    exit;
}

// Query untuk mengambil data dari tabel pengaduan dengan sorting
$query = "SELECT * FROM pengaduan ORDER BY 
          CASE status 
            WHEN 'belum diproses' THEN 1
            WHEN 'diproses' THEN 2
            WHEN 'selesai' THEN 3
          END, tanggal DESC";
$result = $conn->query($query);

if ($result === false) {
    echo "Error: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .testimonial-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            position: relative;
        }

        .testimonial-item:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-badge.belum {
            background-color: #ffc107;
            color: #000;
        }

        .status-badge.diproses {
            background-color: #17a2b8;
            color: #fff;
        }

        .status-badge.selesai {
            background-color: #28a745;
            color: #fff;
        }

        .progress-container {
            margin-top: 15px;
            margin-bottom: 10px;
        }

        .progress {
            height: 10px;
            border-radius: 5px;
        }

        .progress-bar {
            border-radius: 5px;
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .pengaduan-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .testimonial-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .testimonial-header h4 {
            margin: 0;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .quote-icon-left,
        .quote-icon-right {
            font-size: 20px;
            color: #ccc;
        }

        .text-right {
            font-size: 14px;
            color: #6c757d;
        }

        .action-buttons {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Page</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
        
        <div class="sidebar-brand-icon d-flex flex-column align-items-center justify-content-center">
        <img src="../img/logo sd.png" alt="Logo" style="width: 80px; height: 80px; margin-bottom: 5px; margin-top: 20px;">     
        </div>  
            <a class="sidebar-brand d-flex flex-column align-items-center justify-content-center">
                <div class="sidebar-brand-text mx-3 text-center">SDN BANGETAYU WETAN 02</div>
            </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="../beranda/beranda.php">
                <i class="fas fa-fw fa-home"></i> <!-- Ikon rumah untuk Beranda -->
                <span>Beranda</span>
            </a>
        </li>

        <!-- Nav Item - Profil -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user"></i> <!-- Ikon user untuk Profil -->
                <span>Profil</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="../profil_sekolah/profil_sekolah.php">Profil Sekolah</a>
                    <a class="collapse-item" href="../profil_guru/guru.php">Profil Guru</a>
                    <a class="collapse-item" href="../profil_karyawan/profil_karyawan.php">Profil Karyawan</a>
                    <a class="collapse-item" href="../prestasi_sekolah/prestasi_sekolah.php">Prestasi Sekolah</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Lomba-Lomba -->
        <li class="nav-item">
            <a class="nav-link" href="../lomba_sekolah/lomba.php">
                <i class="fas fa-fw fa-trophy"></i> <!-- Ikon trofi untuk Lomba -->
                <span>Lomba-Lomba</span>
            </a>
        </li>

        <!-- Nav Item - Berita -->
        <li class="nav-item">
            <a class="nav-link" href="../berita_sekolah/berita_sekolah.php">
                <i class="fas fa-fw fa-newspaper"></i> <!-- Ikon surat kabar untuk Berita -->
                <span>Berita</span>
            </a>
        </li>

        <!-- Nav Item - Pelayanan Publik -->
        <li class="nav-item active">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-cogs"></i> <!-- Ikon pengaturan untuk Pelayanan Publik -->
                <span>Pelayanan Publik</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item active" href="../pengaduan/pengaduan.php">Pengaduan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Web Terkait -->
        <li class="nav-item">
        <a class="nav-link" href="../website/website.php">
            <i class="fas fa-fw fa-globe"></i>
            <span>Web Terkait</span>
        </a>
        </li>

        <!-- Nav Item - Kontak -->
        <li class="nav-item">
            <a class="nav-link" href="../kontak/edit_kontak.php">
                <i class="fas fa-fw fa-phone-alt"></i> <!-- Ikon telepon untuk Kontak -->
                <span>Kontak</span>
            </a>
        </li>

        <!-- Nav Item - Kelola User -->
        <li class="nav-item">
            <a class="nav-link" href="../users/users.php">
                <i class="fas fa-fw fa-users-cog"></i> <!-- Ikon pengaturan pengguna untuk Kelola User -->
                <span>Kelola User</span>
            </a>
        </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                                <span class="text-gray-600">Logout</span>
                            </a>
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <!-- Use modal trigger here -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
          <div class="container-fluid">
            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div cslass="modal-header">
                            <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus sarana prasarana ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <a id="confirmHapusBtn" href="#" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Page Heading -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800 font-weight-bold">Pengaduan</h1>
                    <p class="mb-4">Kelola pengaduan yang masuk dengan mengupdate status progresnya.</p>

                    <div class="container mt-4">
                        <div class="row gy-4">
                            <?php
                            $count = 0;
                            while ($row = $result->fetch_assoc()) {
                                $nama = htmlspecialchars($row['nama']);
                                $deskripsi = htmlspecialchars($row['deskripsi']);
                                $email = htmlspecialchars($row['email']);
                                $no_kontak = htmlspecialchars($row['no_kontak']);
                                $tanggal = htmlspecialchars($row['tanggal']);
                                $status = htmlspecialchars($row['status']);
                                $no_tiket = htmlspecialchars($row['no_tiket']);
                                
                                // Tentukan warna badge berdasarkan status
                                $badge_class = '';
                                if ($status == 'belum diproses') $badge_class = 'belum';
                                elseif ($status == 'diproses') $badge_class = 'diproses';
                                elseif ($status == 'selesai') $badge_class = 'selesai';
                                
                                // Tentukan progress bar
                                $progress = 0;
                                if ($status == 'diproses') $progress = 50;
                                elseif ($status == 'selesai') $progress = 100;
                                
                                $delay = 100 * ($count + 1);
                            ?>
                            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
                                <div class="testimonial-item shadow p-4 rounded">
                                    <!-- Status Badge -->
                                    <span class="status-badge <?= $badge_class ?>"><?= strtoupper($status) ?></span>
                                    
                                    <!-- Testimonial Header -->
                                    <div class="testimonial-header">
                                        <img src="../img/avatar.png" class="pengaduan-img rounded-circle" alt="Avatar">
                                        <div>
                                            <h3><?= $nama; ?></h3>
                                            <h4 class="text-muted small">
                                                No. Tiket: <?= $no_tiket; ?>
                                            </h4>
                                            <?php
                                            $subject = rawurlencode("Tanggapan Pengaduan #$no_tiket");
                                            $body = rawurlencode("Halo $nama,\n\nKami telah menerima pengaduan Anda (No. Tiket: $no_tiket) dan status saat ini: $status.\n\nTerima kasih.");
                                            $gmailLink = "https://mail.google.com/mail/?view=cm&fs=1&to=$email&su=$subject&body=$body";
                                            $wa_number = preg_replace('/[^0-9]/', '', $no_kontak);
                                            ?>
                                            <h4 class="text-muted small">
                                                Email: <a href="<?= $gmailLink; ?>" target="_blank"><?= $email; ?></a> |
                                                Telp: <a href="https://wa.me/+62<?= $wa_number; ?>" target="_blank"><?= $no_kontak; ?></a>
                                            </h4>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-3">
                                    
                                    <!-- Progress Bar -->
                                    <div class="progress-container">
                                        <div class="progress">
                                            <div class="progress-bar bg-<?= $badge_class ?>" role="progressbar" style="width: <?= $progress ?>%" 
                                                aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">Progres: <?= $progress ?>%</small>
                                    </div>
                                    
                                    <!-- Deskripsi Pengaduan -->
                                    <h5>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span><?= $deskripsi; ?></span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </h5>
                                    
                                    <!-- Form Update Status -->
                                    <form method="POST" class="mt-3">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="hidden" name="update_status" value="1"> <!-- Tambahkan ini -->
    <div class="form-group">
        <label for="status">Update Status:</label>
        <select name="status" class="form-control" onchange="this.form.submit()">
            <option value="belum diproses" <?= $status == 'belum diproses' ? 'selected' : '' ?>>Belum Diproses</option>
            <option value="diproses" <?= $status == 'diproses' ? 'selected' : '' ?>>Sedang Diproses</option>
            <option value="selesai" <?= $status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
    </div>
</form>

                                    
                                    <!-- Tanggal -->
                                    <div class="text-right text-muted small mt-2">
                                        <?= date('d M Y H:i', strtotime($tanggal)); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $count++;
                            }
                            ?>
                        </div>
                    </div>
                </div>



                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SDN Bangetayu Wetan 02</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
</body>
<?php
// Menutup koneksi database
$conn->close();
?>
</html>