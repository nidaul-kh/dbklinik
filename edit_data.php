<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_rekam = $_GET['id'];
    
    $sql = "SELECT * FROM pasien WHERE no_norm = '$id_rekam'";
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
    $nama_pasien = $_POST['nama_pasien'];
    $jk = $_POST['jk'];
    $no_hp = $_POST['no_hp'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $tempat_lahir = $_POST['tempat_lahir'];

    $update_sql = "UPDATE pasien SET nama_pasien='$nama_pasien', jk='$jk', no_hp='$no_hp', tgl_lahir='$tgl_lahir', tempat_lahir='$tempat_lahir' WHERE no_norm='$id_rekam'";
    
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
    <title>Edit Pasien</title>
</head>
<body>
    <h2>Edit Data Pasien</h2>
    <form method="post">
        <label for="nama_pasien">Nama Pasien:</label>
        <input type="text" id="nama_pasien" name="nama_pasien" value="<?php echo $row['nama_pasien']; ?>" required><br><br>
        
        <label for="jk">Jenis Kelamin:</label>
        <input type="text" id="jk" name="jk" value="<?php echo $row['jk']; ?>" required><br><br>
        
        <label for="no_hp">No Handphone:</label>
        <input type="text" id="no_hp" name="no_hp" value="<?php echo $row['no_hp']; ?>" required><br><br>

        <label for="tgl_lahir">Tanggal Lahir:</label>
        <input type="date" id="tgl_lahir" name="tgl_lahir" value="<?php echo $row['tgl_lahir']; ?>" required><br><br>

        <label for="tempat_lahir">Tempat Lahir:</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?php echo $row['tempat_lahir']; ?>" required><br><br>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php"><button type="button">Batal</button></a>
    </form>
</body>
</html>
