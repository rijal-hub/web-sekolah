<?php
function kirimPengaduan($conn, $nama, $no_kontak, $email, $deskripsi) {
    // Atur zona waktu (sesuaikan dengan lokasi Anda)
    date_default_timezone_set('Asia/Jakarta');  // Contoh untuk WIB
    
    // Generate nomor tiket dengan timestamp lengkap (tahun-bulan-tanggal-jam-menit-detik)
    $no_tiket = 'TKT-' . date('YmdHis') . '-' . bin2hex(random_bytes(2));

    // Debugging: Cek data yang diterima
    echo "Data yang diterima: Nama: $nama, No Kontak: $no_kontak, Email: $email, Deskripsi: $deskripsi, No Tiket: $no_tiket<br>";

    // Siapkan query untuk menyimpan pengaduan
    $query = "INSERT INTO pengaduan (nama, no_kontak, email, deskripsi, status, no_tiket, tanggal) 
              VALUES (?, ?, ?, ?, 'belum diproses', ?, NOW())";  // Gunakan NOW() untuk waktu server
    
    // Persiapkan statement
    $stmt = $conn->prepare($query);
    
    // Cek apakah persiapan query berhasil
    if (!$stmt) {
        die("Gagal menyiapkan query: " . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param("sssss", $nama, $no_kontak, $email, $deskripsi, $no_tiket);

    // Debugging: Cek apakah query berhasil dijalankan
    if ($stmt->execute()) {
        echo "Data berhasil dimasukkan ke database.<br>";
        return [
            'status' => true,
            'message' => 'Pengaduan berhasil dikirim. Nomor tiket Anda: ' . $no_tiket,
            'no_tiket' => $no_tiket
        ];
    } else {
        // Debugging: Jika query gagal, tampilkan error
        die("Gagal mengirim pengaduan: " . $stmt->error);
    }
}
?>
