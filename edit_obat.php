<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_rekam = $_GET['id'];
    
    $sql = "SELECT * FROM obat WHERE id_obat";
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
    $nama_obat = $_POST['nama_obat'];
    $dosis = $_POST['dosis'];
    
    $update_sql = "UPDATE obat SET nama_obat='$nama_obat', dosis='$dosis' WHERE id_rekam='$id_rekam'";
    
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
    <title>Edit Obat</title>
</head>
<body>
    <h2>Edit Obat</h2>
    <form method="post">
        <label for="nama_obat">Nama Obat:</label>
        <input type="text" id="nama_obat" name="nama_obat" value="<?php echo $row['nama_obat']; ?>" required><br><br>
        
        <label for="dosis">Dosis:</label>
        <input type="text" id="dosis" name="dosis" value="<?php echo $row['dosis']; ?>" required><br><br>
        
        <button type="submit">Simpan Perubahan</button>
        <button><a href="index.php">Batal</ba></button>
    </form>
</body>
</html>