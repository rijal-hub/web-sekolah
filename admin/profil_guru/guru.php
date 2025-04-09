<?php
// Include file db_connect.php untuk koneksi ke database
include 'db_connect.php';

// Query untuk mengambil data dari tabel 
$query = "SELECT * FROM profil_guru";
$result = $conn->query($query);

// Cek apakah query berhasil
if ($result === false) {
    // Jika gagal, tampilkan error SQL
    echo "Error: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Page</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
        
        <div class="sidebar-brand-icon d-flex flex-column align-items-center justify-content-center">
        <img src="../img/logo sd.png" alt="Logo" style="width: 80px; height: 80px; margin-bottom: 5px; margin-top: 20px;">     
        </div>  
            <a class="sidebar-brand d-flex flex-column align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3 text-center">SDN BANGETAYU WETAN 02</div>
            </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
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
                    <a class="collapse-item" href="../kegiatan_sekolah/kegiatan.php">Kegiatan Sekolah</a>
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
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-cogs"></i> <!-- Ikon pengaturan untuk Pelayanan Publik -->
                <span>Pelayanan Publik</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="../pengaduan/pengaduan.php">Pengaduan</a>
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

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
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
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800 font-weight-bold">Guru SDN Bangetayu Wetan 02</h1>
                    <p class="mb-4">Halaman ini menampilkan daftar Guru di SDN Bangetayu Wetan 02. Pastikan data yang ditampilkan selalu diperbarui untuk memberikan gambaran yang jelas mengenai pencapaian sekolah.</p>

                    <!-- Konten-->
                <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <!-- Tombol Tambah dengan Icon Plus -->
                    <a href="tambah_guru.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah guru
                    </a>
                </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Foto</th>
                                        <th>NIP</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Mengecek apakah ada data
                                    if ($result->num_rows > 0) {
                                        // Menampilkan data dari tabel guru_sekolah
                                        $no = 1;
                                        while($guru = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$no}</td>";
                                            echo "<td>{$guru['nama']}</td>";
                                            echo "<td><img src='uploads/{$guru['foto']}' alt='Foto guru' width='100'></td>";
                                            echo "<td>{$guru['nip']}</td>";
                                            echo "<td>{$guru['jabatan']}</td>";
                                            echo "<td>
                                                    <a href='edit_guru.php?id={$guru['id']}' class='btn btn-warning d-flex justify-content-center'>Edit</a>
                                                    <a href='hapus_guru.php?id={$guru
                                                    ['id']}' class='btn btn-danger d-flex'>Hapus</a>
                                                </td>";
                                            echo "</tr>";
                                            $no++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>Data tidak tersedia</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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
                        <span>Copyright &copy; Your Website 2020</span>
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
                    <a class="btn btn-primary" href="login.html">Logout</a>
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
    <script>
    // Menangani event klik pada tombol Hapus
    document.querySelectorAll('.btn-hapus').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi default (mengarah ke halaman hapus.php langsung)
            
            // Ambil ID sarana prasarana yang akan dihapus
            var id = this.getAttribute('data-id');
            
            // Set link href pada tombol konfirmasi modal
            var url = "hapus_sarana.php?id=" + id;
            document.getElementById('confirmHapusBtn').setAttribute('href', url);
            
            // Tampilkan modal konfirmasi
            $('#hapusModal').modal('show');
        });
    });

    </script>
</body>
<?php
// Menutup koneksi database
$conn->close();
?>
</html>