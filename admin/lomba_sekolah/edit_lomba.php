<?php
session_start(); // WAJIB sebelum HTML atau echo apapun

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
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
// Koneksi ke database untuk mengambil data jenis lomba
$query_jenis_lomba = "SELECT * FROM jenis_lomba"; // Menampilkan semua jenis lomba
$result_jenis_lomba = $conn->query($query_jenis_lomba);
?>

<?php
// Include file db_connect.php untuk koneksi ke database
include 'db_connect.php';

// Cek apakah ada parameter 'id' di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data lomba berdasarkan id
    $query = "SELECT * FROM lomba_lomba WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $lomba = $result->fetch_assoc();
    } else {
        echo "Lomba tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}

// Fungsi untuk ekstrak ID video YouTube dari URL
function extractYouTubeID($url) {
    if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
        return $matches[1];
    }
    return null;
}

$jenis_lomba = isset($_POST['jenis_lomba']) ? $_POST['jenis_lomba'] : $lomba['jenis_lomba'];
$jenis_media = isset($_POST['jenis_media']) ? $_POST['jenis_media'] : $lomba['jenis_media'];

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['nama_lomba'];
    $jenis_lomba = $_POST['jenis_lomba'];
    $jenis_media = $_POST['jenis_media'];
    $deskripsi = $_POST['deskripsi'];
    $media = null;

    // Cek apakah ada file foto atau URL YouTube yang diupload
    if ($_FILES['media']['error'] == 0) {
        $foto = $_FILES['media'];
        $foto_name = $foto['name'];
        $foto_tmp = $foto['tmp_name'];

        // Menyimpan foto di folder uploads
        move_uploaded_file($foto_tmp, 'uploads/' . $foto_name);
        $media = $foto_name;
    } elseif (!empty($_POST['media'])) {
        // Jika ada URL YouTube yang dimasukkan, ekstrak ID video
        $youtube_url = $_POST['media'];
        $video_id = extractYouTubeID($youtube_url);
        if ($video_id) {
            $media = "https://youtu.be/" . $video_id; // Embed video YouTube
        }
    }

    // Update database dengan media baru (foto atau link YouTube)
    if ($media !== null) {
        $query = "UPDATE lomba_lomba SET nama_lomba = ?, jenis_lomba = ?, jenis_media = ?, deskripsi = ?, media = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $judul, $jenis_lomba, $jenis_media, $deskripsi, $media, $id);
    } else {
        // Update query tanpa media
        $query = "UPDATE lomba_lomba SET nama_lomba = ?, jenis_lomba = ?, jenis_media = ?, deskripsi = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $judul, $jenis_lomba, $jenis_media, $deskripsi, $id);
    }

    // Eksekusi query update
    if ($stmt->execute()) {
        echo "Lomba berhasil diperbarui!";
        header("Location: lomba.php"); // Kembali ke halaman daftar lomba setelah update
        exit;
    } else {
        echo "Error: " . $conn->error;
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
    <link href=".//vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

       <!-- Sidebar -->
       <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
        
        <div class="sidebar-brand-icon d-flex flex-column align-items-center justify-content-center">
        <img src="../beranda/uploads/<?php echo $beranda['logo']; ?>" alt="Logo" style="width: 80px; height: 80px; margin-bottom: 5px; margin-top: 20px;">
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
                    <a class="collapse-item" href="../prestasi_sekolah/prestasi_sekolah.php">Prestasi Sekolah</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Lomba-Lomba -->
        <li class="nav-item active">
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
                    <h1 class="h3 mb-2 text-gray-800 font-weight-bold">Edit lomba</h1>
                    <p class="mb-4">Halaman ini digunakan untuk menambah data lomba sekolah.</p>

                    <!-- Konten-->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Edit lomba</h6>
                        </div>
                        <div class="card-body">
                        <form action="edit_lomba.php?id=<?php echo $lomba['id']; ?>" method="POST" enctype="multipart/form-data">
                            <div>
                                <label for="nama_lomba">Nama lomba:</label>
                                <input type="text" class="form-control" name="nama_lomba" id="nama_lomba" value="<?php echo $lomba['nama_lomba']; ?>" required>
                            </div>
                                                
                        <!-- Dropdown untuk memilih jenis lomba -->
                        <div class="form-group">
                            <label for="jenis_lomba">Jenis Lomba</label>
                            <div class="d-flex">
                                <select class="form-control" id="jenis_lomba" name="jenis_lomba" required>
                                    <option>--- Pilih Jenis Lomba ---</option>
                                    <?php
                                    // Cek apakah query berhasil
                                    if ($result_jenis_lomba->num_rows > 0) {
                                        // Tampilkan setiap jenis lomba sebagai opsi dalam dropdown
                                        while ($row = $result_jenis_lomba->fetch_assoc()) {
                                            // Jika jenis lomba ini adalah yang terpilih
                                            $selected = ($row['id'] == $jenis_lomba) ? 'selected' : '';
                                            echo "<option value='" . $row['id'] . "' $selected>" . $row['nama_lomba'] . "</option>";
                                        }
                                    } else {
                                        echo "<option disabled>No data available</option>";
                                    }
                                    ?>
                                </select>

                                <!-- Tombol + untuk menambahkan jenis lomba baru -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addJenisLombaModal">+</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_media">Jenis Media</label>
                            <select class="form-control" id="jenis_media" name="jenis_media" required>
                                <option value="foto" <?php echo ($jenis_media == 'foto') ? 'selected' : ''; ?>>Foto</option>
                                <option value="video" <?php echo ($jenis_media == 'video') ? 'selected' : ''; ?>>Video</option>
                            </select>
                        </div>
                            <label>Media saat ini:</label><br>
                            <?php
                            if (filter_var($lomba['media'], FILTER_VALIDATE_URL)) {
                                            // Jika media berupa URL video (YouTube atau youtu.be)
                                            if (strpos($lomba['media'], 'youtube') !== false || strpos($lomba['media'], 'youtu.be') !== false) {
                                                // Cek apakah URLnya dari youtu.be
                                                if (strpos($lomba['media'], 'youtu.be') !== false) {
                                                    // Mengambil ID video dari URL youtu.be
                                                    preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $lomba['media'], $matches);
                                                    $video_id = $matches[1]; // ID video
                                                } else {
                                                    // Jika URL dari youtube.com, ambil ID video setelah 'v='
                                                    parse_str(parse_url($lomba['media'], PHP_URL_QUERY), $url_params);
                                                    $video_id = isset($url_params['v']) ? $url_params['v'] : ''; // ID video
                                                }
                                                
                                                // Membuat URL embed
                                                $embed_url = "https://www.youtube.com/embed/{$video_id}";
                                                echo "<iframe width='200' src='{$embed_url}' frameborder='0' allowfullscreen></iframe>";
                                            } else {
                                                // Jika media adalah URL selain video (misalnya link gambar eksternal)
                                                echo "<a href='{$lomba['media']}' target='_blank'>Lihat Media</a>";
                                            }
                                        } else {
                                            // Jika media berupa file gambar
                                            echo "<img src='uploads/{$lomba['media']}' alt='media lomba' width='200'>";
                                        }?><br>
                                     <label for="media">Media:</label>
                                        <!-- Input untuk file media -->
                                        <input type="file" class="form-control" name="media" id="media">

                                        <p>Atau masukkan URL YouTube:</p>
                                        <!-- Input untuk URL YouTube, tidak menampilkan nilai sebelumnya -->
                                        <input type="url" class="form-control" name="media" id="media" placeholder="https://youtu.be/">

                            <div>
                                <label for="deskripsi">Deskripsi:</label>
                                <textarea name="deskripsi" class="form-control" id="deskripsi" required><?php echo $lomba['deskripsi']; ?></textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" >Update lomba</button>
                            </div>
                        </form>
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