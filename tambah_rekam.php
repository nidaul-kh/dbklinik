<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_norm = $_POST['no_norm'];
    $tanggal_kunjungan = $_POST['tanggal_kunjungan']; // Sesuaikan dengan nama kolom di database
    $diagnosis = $_POST['diagnosis'];
    $tindakan = $_POST['tindakan'];
    $dokter = $_POST['dokter'];
    
    $sql = "INSERT INTO rekam_medis (no_norm, tanggal_kunjungan, diagnosis, tindakan, dokter) 
            VALUES ('$no_norm', '$tanggal_kunjungan', '$diagnosis', '$tindakan', '$dokter')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Rekam medis berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rekam Medis</title>
</head>
<body>
    <h2>Tambah Rekam Medis</h2>
    <form method="post">
        <label for="no_norm">No. RM (Nomor Rekam Medis):</label>
        <input type="text" id="no_norm" name="no_norm" required><br><br>
        
        <label for="tanggal_kunjungan">Tanggal Kunjungan:</label> <!-- Sesuaikan label -->
        <input type="date" id="tanggal_kunjungan" name="tanggal_kunjungan" required><br><br>
        
        <label for="diagnosis">Diagnosis:</label>
        <input type="text" id="diagnosis" name="diagnosis" required><br><br>
        
        <label for="tindakan">Tindakan:</label>
        <input type="text" id="tindakan" name="tindakan" required><br><br>
        
        <label for="dokter">Dokter:</label>
        <input type="text" id="dokter" name="dokter" required><br><br>
        
        <button type="submit">Simpan</button>
        <a href="index.php"><button type="button">Batal</button></a>
    </form>
</body>
</html>
