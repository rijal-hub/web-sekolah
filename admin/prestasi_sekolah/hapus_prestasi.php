<?php
// Include file db_connect.php untuk koneksi ke database
include 'db_connect.php';

// Cek apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data prestasi berdasarkan ID
    $query = "SELECT * FROM prestasi_sekolah WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $prestasi = $result->fetch_assoc();
        $foto = $prestasi['foto'];

        // Menghapus foto dari server jika ada
        if ($foto && file_exists('uploads/' . $foto)) {
            unlink('uploads/' . $foto);
        }

        // Query untuk menghapus data prestasi berdasarkan ID
        $deleteQuery = "DELETE FROM prestasi_sekolah WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);

        // Eksekusi query hapus
        if ($deleteStmt->execute()) {
            // Jika berhasil, redirect ke halaman daftar prestasi
            header("Location: prestasi_sekolah.php");
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
