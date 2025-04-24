<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_norm = $_POST['no_norm'] ?? ''; 
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'] ?? ''; 
    $jumlah = $_POST['jumlah'] ?? ''; 
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? ''; // Sesuai dengan form

    // Validasi agar tanggal tidak kosong
    if (empty($tanggal_pembayaran)) {
        die("<script>alert('Tanggal pembayaran tidak boleh kosong!'); window.history.back();</script>");
    }

    $sql = "INSERT INTO pembayaran (no_norm, tanggal_pembayaran, jumlah, metode_pembayaran) 
            VALUES ('$no_norm', '$tanggal_pembayaran', '$jumlah', '$metode_pembayaran')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pembayaran berhasil ditambahkan!'); window.location.href='index.php';</script>";
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
    <title>Tambah Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
            margin-top: 10px;
        }

        .cancel-btn:hover {
            background-color: #e53935;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
            color: white;
        }

        .alert-success { background-color: #4CAF50; }
        .alert-warning { background-color: #ff9800; }
        .alert-danger { background-color: #f44336; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Pembayaran</h2>
        <form method="post">
            <label for="no_norm">No. RM (Nomor Rekam Medis):</label>
            <input type="text" id="no_norm" name="no_norm" required placeholder="Masukkan No. RM"><br>

            <label for="tanggal_pembayaran">Tanggal Pembayaran:</label>
            <input type="date" id="tanggal_pembayaran" name="tanggal_pembayaran" required><br>

            <label for="jumlah">Jumlah Pembayaran:</label>
            <input type="number" id="jumlah" name="jumlah" required placeholder="Masukkan Jumlah Pembayaran"><br>

            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <input type="text" id="metode_pembayaran" name="metode_pembayaran" required placeholder="Masukkan Metode Pembayaran"><br>

            <button type="submit">Simpan Pembayaran</button>
            <a href="index.php"><button type="button" class="cancel-btn">Batal</button></a>
        </form>

        <div class="footer">
            <p>Kembali ke <a href="index.php">Dashboard</a></p>
        </div>
    </div>
</body>
</html>
