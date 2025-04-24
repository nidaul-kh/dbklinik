<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $no_norm = $_GET['id'];

    // Query untuk menghapus data pasien
    $sql = "DELETE FROM rekam_medis WHERE no_norm='$no_norm'"; // Perbaikan di sini

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, tampilkan pesan dan redirect ke index.php setelah beberapa detik
        echo "Data pasien berhasil dihapus.";
        header("refresh:1;url=index.php"); // Redirect ke index.php setelah 1 detik
    } else {
        // Jika gagal, tampilkan pesan error dan redirect ke index.php
        echo "Error: " . $conn->error;
        header("refresh:1;url=index.php"); // Redirect ke index.php setelah 1 detik
    }

    $conn->close();
}
?>