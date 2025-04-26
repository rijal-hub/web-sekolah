<?php
function kirimPengaduan($conn, $nama, $no_kontak, $email, $deskripsi) {
    // Set the timezone (adjust as needed)
    date_default_timezone_set('Asia/Jakarta');  // For example, WIB timezone
    
    // Generate ticket number using timestamp (year-month-day-hour-minute-second)
    $timestamp = date('YmdHis'); // Format: YYYMMDDHHMMSS
    $randomPart = bin2hex(random_bytes(1)); // 1 byte = 2 hex characters, max length of 4 characters
    
    // Ensure that the ticket number is exactly 20 characters, with "TKT-" as the prefix
    $no_tiket = 'TKT-' . substr($timestamp . '-' . $randomPart, 4, 16);  // Limit the length to 20 characters
    
    // Prepare the query to insert the complaint
    $query = "INSERT INTO pengaduan (nama, no_kontak, email, deskripsi, status, no_tiket, tanggal) 
              VALUES (?, ?, ?, ?, 'belum diproses', ?, NOW())";  // NOW() for server's current time
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    
    // Check if the preparation was successful
    if (!$stmt) {
        die("Gagal menyiapkan query:" . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("sssss", $nama, $no_kontak, $email, $deskripsi, $no_tiket);

    // Debugging: Check if the query executed successfully
    if ($stmt->execute()) {
        return [
            'status' => true,
            'message' => 'Pengaduan berhasil dikirim. Nomor tiket Anda: ' . $no_tiket,
            'no_tiket' => $no_tiket,
            'tanggal' => date('Y-m-d H:i:s')  // Capture the submission time
        ];
    } else {
        // If the query failed, display the error
        die("Gagal mengirim pengaduan: " . $stmt->error);
    }
}
?>
