<?php
// Include file db_connect.php untuk koneksi ke database
include 'config/db_connect.php';

function kirimPengaduan($conn, $nama, $no_kontak, $email, $deskripsi)
{
    $tanggal = date('Y-m-d'); // Mengambil tanggal hari ini

    // Gunakan prepared statement untuk keamanan
    $query = "INSERT INTO pengaduan (nama, deskripsi, email, no_kontak, tanggal) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);

    // Tambahan: cek apakah prepare berhasil
    if (!$stmt) {
        return [
            'status' => false,
            'message' => "Prepare failed: " . $conn->error
        ];
    }

    $stmt->bind_param("sssss", $nama, $deskripsi, $email, $no_kontak, $tanggal);

    $result = [];
    if ($stmt->execute()) {
        $result['status'] = true;
        $result['message'] = "Pengaduan Anda telah terkirim dan berhasil disimpan!";
    } else {
        $result['status'] = false;
        $result['message'] = "Terjadi kesalahan saat menyimpan: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    return $result;
}
?>
