<?php
session_start(); // WAJIB sebelum HTML atau echo apapun

// Cek login status
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}?>
<?php
// Koneksi ke database
include 'db_connect.php';

// Ambil data untuk halaman beranda
$id = 1; // ID tetap 1
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
?>
<?php
// Koneksi ke database
include 'db_connect.php';

// Ambil data untuk halaman beranda
$id = 1; // ID tetap 1
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
?>
<?php

// Koneksi ke database
include 'db_connect.php';

// Upload Foto (Slider)
if (isset($_POST['upload'])) {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $filename = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $target_dir = "uploads/";

        // Cek apakah file berhasil diupload
        if (move_uploaded_file($tmp_name, $target_dir . $filename)) {
            // Masukkan data gambar ke dalam database
            $query = "INSERT INTO slider (foto) VALUES ('$filename')";
            mysqli_query($conn, $query);
        } else {
            echo "Gagal mengupload file!";
        }
    }
}

// Hapus Gambar dari Slider
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Ambil data gambar berdasarkan ID
    $query = mysqli_query($conn, "SELECT * FROM slider WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    // Hapus file gambar dari folder uploads
    unlink("uploads/" . $data['foto']);
    // Hapus data gambar dari database
    mysqli_query($conn, "DELETE FROM slider WHERE id = $id");
    header("Location: beranda.php"); // Refresh halaman
}

// Ambil data untuk halaman beranda
$id = 1;
$query = "SELECT * FROM beranda WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $beranda = $result->fetch_assoc();
} else {
    echo "Data beranda tidak ditemukan.";
    exit;
}

// Proses update data beranda
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nama_Kepsek = $_POST['Nama_Kepsek'];
    $sambutan = $_POST['sambutan'];

    // Inisialisasi variabel untuk menyimpan nama file
    $logo = $beranda['logo'];
    $foto_kepsek = $beranda['foto_kepsek'];

    // Fungsi untuk mengupload foto dan mengupdate variabel jika ada file yang diunggah
    function uploadFoto($input_name, &$foto_var, $old_file = '') {
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
            $foto = $_FILES[$input_name];
            $foto_name = basename($foto['name']);
            $foto_tmp = $foto['tmp_name'];
            $foto_path = 'uploads/' . $foto_name;

            // Hapus file lama jika ada
            if ($old_file && file_exists('uploads/' . $old_file)) {
                unlink('uploads/' . $old_file);
            }

            // Cek dan pindahkan file
            if (move_uploaded_file($foto_tmp, $foto_path)) {
                $foto_var = $foto_name; // Perbarui variabel jika berhasil diupload
            } else {
                echo "Gagal mengupload $input_name.";
                exit;
            }
        }
    }

    // Upload foto jika ada file yang diunggah
    uploadFoto('logo', $logo, $beranda['logo']);
    uploadFoto('foto_kepsek', $foto_kepsek, $beranda['foto_kepsek']);

    // Query untuk update database dengan data baru
    $query = "UPDATE beranda SET 
                logo = ?,  
                foto_kepsek = ?, 
                Nama_Kepsek = ?, 
                sambutan = ? 
              WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $logo, $foto_kepsek, $Nama_Kepsek, $sambutan, $id);

    // Eksekusi query update
    if ($stmt->execute()) {
        echo "Beranda berhasil diperbarui!";
        header("Location: beranda.php"); // Kembali ke halaman daftar beranda setelah update
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
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

    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <div class="sidebar-brand-icon d-flex flex-column align-items-center justify-content-center">
    <img src="uploads/<?php echo $beranda['logo']; ?>" alt="Logo" style="width: 80px; height: 80px; margin-bottom: 5px; margin-top: 20px;">
    </div>  
    <a class="sidebar-brand d-flex flex-column align-items-center justify-content-center">
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
                    <h1 class="h3 mb-2 text-gray-800 font-weight-bold">Beranda SDN Bangetayu Wetan 02</h1>
                    <p class="mb-4">Halaman ini berisi informasi yang akan ditampilkan di halaman beranda website SDN Bangetayu Wetan 02.</p>
                  <!-- Konten-->
                  <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Slider</h6>
                </div>
                <div class="card-body">
                    <!-- Flex container untuk form tambah & list gambar -->
                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <!-- Form Tambah Foto -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div style="width: 300px; height: 150px; border: 2px dashed red; display: flex; justify-content: center; align-items: center; cursor: pointer;" onclick="document.getElementById('fileInput').click()">
                                + Tambah Foto
                            </div>
                            <input type="file" name="foto" id="fileInput" style="display: none;" onchange="this.form.submit()">
                            <input type="hidden" name="upload" value="1">
                        </form>

                        <!-- Gambar slider -->
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM slider ORDER BY id DESC");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                                <div style="position: relative; width: 300px; height: 150px;">
                                    <img src="uploads/'.$row['foto'].'" width="300" height="150" style="object-fit: cover;">
                                    <a href="?delete='.$row['id'].'" style="position: absolute; top: 0; right: 0; color: white; background: red; padding: 1px 6px; text-decoration: none;">x</a>
                                </div>
                            ';
                        }
                        ?>
                    </div>

                </div>
            </div>



                  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Halaman Beranda</h6>
                        </div>
                        <div class="card-body">
                        <form action="beranda.php?id=<?php echo $beranda['id']; ?>" method="POST" enctype="multipart/form-data">
                            <div>
                                <label for="foto">Logo Sekolah:</label><br>
                                <img src="uploads/<?php echo $beranda['logo']; ?>" width="200">
                                <input type="file" class="form-control" name="logo" id="logo">
                            </div><br>
                            <div>
                                <label for="foto">Foto Kepala Sekolah:</label>
                                <br> <img src="uploads/<?php echo $beranda['foto_kepsek']; ?>" width="200">
                                <input type="file" class="form-control" name="foto_kepsek" id="foto_kepsek">
                            </div><br>
                            <div>
                                <label for="Nama_Kepsek">Nama Kepala Sekolah:</label>
                                <input type="text" class="form-control" name="Nama_Kepsek" id="Nama_Kepsek" value="<?php echo $beranda['Nama_Kepsek']; ?>" required>
                            </div><br>
                            <div>
                                <label for="sambutan">Sambutan:</label>
                                <textarea name="sambutan" class="form-control" id="sambutan" required><?php echo $beranda['sambutan']; ?></textarea>
                            </div><br>
                            <div>
                            <button type="submit" class="btn btn-primary">Update beranda</button>
                            </div>
                        </form>
                        </div>
                    </div>
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