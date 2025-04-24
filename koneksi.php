<?php
$host = "localhost"; // atau IP server jika tidak di localhost
$user = "root"; // Username database
$pass = ""; // Password database
$dbname = "dbklinik"; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
