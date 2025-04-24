<?php
include 'koneksi.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_norm = $_POST['no_norm'];
    $nama = $_POST['nama_pasien'];
    $jk = $_POST['jk'];
    $no_hp = $_POST['no_hp'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $tempat_lahir = $_POST['tempat_lahir'];

    $cek = $conn->prepare("SELECT no_norm FROM pasien WHERE no_norm = ?");
    $cek->bind_param("s", $no_norm);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>alert('Nomor RM sudah ada! Gunakan nomor lain.'); window.history.back();</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO pasien (no_norm, nama_pasien, jk, no_hp, tgl_lahir, tempat_lahir) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $no_norm, $nama, $jk, $no_hp, $tgl_lahir, $tempat_lahir);

        if ($stmt->execute()) {
            echo "<script>alert('Pasien berhasil ditambahkan!'); window.location.href='index.php';</script>";
        } else {
            echo "Gagal menambahkan pasien: " . $stmt->error;
        }

        $stmt->close();
    }

    $cek->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pasien</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #f4f6f8;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        label {
            margin-top: 10px;
            display: block;
            font-weight: 600;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .btn-submit {
            background-color: #4CAF50;
            color: white;
        }

        .btn-submit:hover {
            background-color: #45a049;
        }

        .btn-cancel {
            background-color: #f44336;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #d32f2f;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .footer a {
            color: #2196F3;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Data Pasien</h2>
    <form method="POST" action="">
        <label for="no_norm">No. Rekam Medis</label>
        <input type="text" id="no_norm" name="no_norm" placeholder="Contoh: RM001" required>

        <label for="nama_pasien">Nama Pasien</label>
        <input type="text" id="nama_pasien" name="nama_pasien" required>

        <label for="jk">Jenis Kelamin</label>
        <input type="text" id="jk" name="jk" placeholder="L / P" required>

        <label for="no_hp">No. HP</label>
        <input type="text" id="no_hp" name="no_hp" required>

        <label for="tgl_lahir">Tanggal Lahir</label>
        <input type="date" id="tgl_lahir" name="tgl_lahir" required>

        <label for="tempat_lahir">Tempat Lahir</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" required>

        <div class="btn-group">
            <button type="submit" class="btn-submit">Simpan</button>
            <button type="button" class="btn-cancel" onclick="window.location.href='index.php'">Batal</button>
        </div>
    </form>
    <div class="footer">
        <p>Kembali ke <a href="index.php">Dashboard</a></p>
    </div>
</div>

</body>
</html>
