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

    // Query untuk mendapatkan data user berdasarkan ID
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $users = $result->fetch_assoc();
                
        // Query untuk menghapus data prestasi berdasarkan ID
        $deleteQuery = "DELETE FROM users WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);

        // Eksekusi query hapus
        if ($deleteStmt->execute()) {
            // Jika berhasil, redirect ke halaman daftar user
            header("Location: users.php");
            exit;
        } else {
            echo "Error: " . $deleteStmt->error;
        }
    } else {
        echo "Admin tidak ditemukan.";
    }
} else {
    echo "ID tidak valid.";
}

// Menutup koneksi database
$conn->close();
?>
