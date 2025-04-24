<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_rekam = $_GET['id'];
    
    $sql = "SELECT * FROM rekam_medis WHERE id_rekam = '$id_rekam'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }
} else {
    echo "ID tidak diberikan.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $diagnosis = $_POST['diagnosis'];
    $tindakan = $_POST['tindakan'];
    $dokter = $_POST['dokter'];
    
    $update_sql = "UPDATE rekam_medis SET diagnosis='$diagnosis', tindakan='$tindakan', dokter='$dokter' WHERE id_rekam='$id_rekam'";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='index.php';</script>";
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
    <title>Edit Rekam Medis</title>
</head>
<body>
    <h2>Edit Rekam Medis</h2>
    <form method="post">
        <label for="diagnosis">Diagnosis:</label>
        <input type="text" id="diagnosis" name="diagnosis" value="<?php echo $row['diagnosis']; ?>" required><br><br>
        
        <label for="tindakan">Tindakan:</label>
        <input type="text" id="tindakan" name="tindakan" value="<?php echo $row['tindakan']; ?>" required><br><br>
        
        <label for="dokter">Dokter:</label>
        <input type="text" id="dokter" name="dokter" value="<?php echo $row['dokter']; ?>" required><br><br>
        
        <button type="submit">Simpan Perubahan</button>
        <button><a href="index.php">Batal</ba></button>
    </form>
</body>
</html>