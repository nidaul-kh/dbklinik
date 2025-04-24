<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_pembayaran = $_GET['id'];
    
    $sql = "SELECT * FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'";
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
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $jumlah = $_POST['jumlah'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    
    $update_sql = "UPDATE pembayaran SET 
        tanggal_pembayaran='$tanggal_pembayaran', 
        jumlah='$jumlah', 
        metode_pembayaran='$metode_pembayaran' 
        WHERE id_pembayaran = '$id_pembayaran'";
    
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
    <title>Edit Pembayaran</title>
</head>
<body>
    <h2>Edit Pembayaran</h2>
    <form method="post">
        <label for="tanggal_pembayaran">Tanggal:</label>
        <input type="date" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?php echo $row['tanggal_pembayaran']; ?>" required><br><br>
        
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" value="<?php echo $row['jumlah']; ?>" required><br><br>
        
        <label for="metode_pembayaran">Metode:</label>
        <select id="metode_pembayaran" name="metode_pembayaran" required>
            <option value="Tunai" <?php if($row['metode_pembayaran'] == 'Tunai') echo 'selected'; ?>>Tunai</option>
            <option value="Kartu_kredit" <?php if($row['metode_pembayaran'] == 'Kartu_kredit') echo 'selected'; ?>>Kartu Kredit</option>
            <option value="Transfer" <?php if($row['metode_pembayaran'] == 'Transfer') echo 'selected'; ?>>Transfer</option>
            <option value="BPJS" <?php if($row['metode_pembayaran'] == 'BPJS') echo 'selected'; ?>>BPJS</option>
        </select>
        <br><br>

        <button type="submit">Simpan Perubahan</button>
        <button type="button" onclick="window.location.href='index.php'">Batal</button>
    </form>
</body>
</html>
