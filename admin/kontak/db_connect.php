<?php
$servername = "localhost";
$username = "root";  // Gantilah dengan username MySQL Anda
$password = "";      // Gantilah dengan password MySQL Anda
$dbname = "bangetayu";  // Gantilah dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>