<?php
session_start(); // WAJIB sebelum HTML atau echo apapun

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}
?>

<?php
// Include file db_connect.php untuk koneksi ke database
include 'db_connect.php';

// Cek apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data profil berdasarkan ID
    $query = "SELECT * FROM profil_karyawan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $karyawan = $result->fetch_assoc();
        $foto = $karyawan['foto'];

        // Menghapus foto dari server jika ada
        if ($foto && file_exists('uploads/' . $foto)) {
            unlink('uploads/' . $foto);
        }

        // Query untuk menghapus data prestasi berdasarkan ID
        $deleteQuery = "DELETE FROM profil_karyawan WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);

        // Eksekusi query hapus
        if ($deleteStmt->execute()) {
            // Jika berhasil, redirect ke halaman daftar profil karyawan
            header("Location: profil_karyawan.php");
            exit;
        } else {
            echo "Error: " . $deleteStmt->error;
        }
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "ID tidak valid.";
}

// Menutup koneksi database
$conn->close();
?>
