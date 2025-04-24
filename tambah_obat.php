<?php
// Koneksi ke database
include 'koneksi.php';

// Inisialisasi variabel pesan
$success = '';
$error = '';

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    if (empty($_POST['id_rekam'])) {
        $error = "ID Rekam Medis harus diisi!";
    } elseif (empty($_POST['nama_obat'])) {
        $error = "Nama Obat harus diisi!";
    } elseif (empty($_POST['dosis'])) {
        $error = "Dosis harus diisi!";
    } elseif (empty($_POST['jumlah']) || !is_numeric($_POST['jumlah'])) {
        $error = "Jumlah harus diisi dengan angka!";
    } else {
        // Escape dan sanitasi input
        $id_rekam = $conn->real_escape_string($_POST['id_rekam']);
        $nama_obat = $conn->real_escape_string($_POST['nama_obat']);
        $dosis = $conn->real_escape_string($_POST['dosis']);
        $jumlah = (int)$_POST['jumlah'];

        // Mulai transaksi
        $conn->begin_transaction();

        try {
            // Query untuk insert data
            $sql = "INSERT INTO obat (id_rekam, nama_obat, dosis, jumlah) 
                    VALUES (?, ?, ?, ?)";
            
            // Prepared statement
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            
            $stmt->bind_param("issi", $id_rekam, $nama_obat, $dosis, $jumlah);
            
            if ($stmt->execute()) {
                $conn->commit();
                $success = "Data obat berhasil ditambahkan!";
                
                // Redirect setelah 2 detik
                header("Refresh: 2; URL=index.php");
            } else {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
            
            $stmt->close();
        } catch (Exception $e) {
            $conn->rollback();
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Obat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Data Obat</h2>
        
        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="tambah_obat.php" method="POST">
            <div class="form-group">
                <label for="id_rekam">ID Rekam Medis:</label>
                <input type="number" id="id_rekam" name="id_rekam" required>
            </div>
            
            <div class="form-group">
                <label for="nama_obat">Nama Obat:</label>
                <input type="text" id="nama_obat" name="nama_obat" required>
            </div>
            
            <div class="form-group">
                <label for="dosis">Dosis:</label>
                <input type="text" id="dosis" name="dosis" required>
            </div>
            
            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" required min="1">
            </div>
            
            <button type="submit">Simpan Data</button>
            <a href="index.php" style="margin-left: 10px;">Kembali</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>