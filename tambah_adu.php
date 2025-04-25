<?php
function kirimPengaduan($conn, $nama, $no_kontak, $email, $deskripsi) {
    // Atur zona waktu (sesuaikan dengan lokasi Anda)
    date_default_timezone_set('Asia/Jakarta');  // Contoh untuk WIB
    
    // Generate nomor tiket dengan timestamp lengkap (tahun-bulan-tanggal-jam-menit-detik)
    $no_tiket = 'TKT-' . date('YmdHis') . '-' . bin2hex(random_bytes(2));
    
    // Siapkan query
    $query = "INSERT INTO pengaduan (nama, no_kontak, email, deskripsi, status, no_tiket, created_at) 
              VALUES (?, ?, ?, ?, 'belum diproses', ?, NOW())";  // Gunakan NOW() untuk waktu server
    
    // Prepare statement
    $stmt = $conn->prepare($query);
    
    // Jika prepare gagal
    if (!$stmt) {
        return [
            'status' => false,
            'message' => 'Gagal menyiapkan query: ' . $conn->error
        ];
    }
    
    function kirimNotifikasiStatus($email, $no_tiket, $status_baru) {
        $subject = "Update Status Pengaduan #$no_tiket";
        $message = "Status pengaduan Anda dengan nomor tiket $no_tiket telah diubah menjadi: $status_baru.\n\n";
        $message .= "Anda dapat melacak status pengaduan di: http://domainanda.com/lacak_pengaduan.php";
        
        $headers = "From: no-reply@domainanda.com";
        
        mail($email, $subject, $message, $headers);
    }
    
    // Bind parameter
    $stmt->bind_param("sssss", $nama, $no_kontak, $email, $deskripsi, $no_tiket);
    
    // Eksekusi
    if ($stmt->execute()) {
        return [
            'status' => true,
            'message' => 'Pengaduan berhasil dikirim. Nomor tiket Anda: ' . $no_tiket,
            'no_tiket' => $no_tiket
        ];
    } else {
        return [
            'status' => false,
            'message' => 'Gagal mengirim pengaduan: ' . $stmt->error
        ];
    }
}


?>