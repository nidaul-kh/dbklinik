<?php
include 'koneksi.php';

// Cek dan buat tabel dokter jika belum ada
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS dokter (
    id_dokter INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialisasi VARCHAR(100) DEFAULT 'Umum'
)");

// Tambah Dokter
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];
    mysqli_query($conn, "INSERT INTO dokter (nama_dokter, spesialisasi) VALUES ('$nama', '$spesialisasi')");
    echo "<script>alert('Data dokter ditambahkan!'); window.location='dokter.php';</script>";
}

// Edit Dokter
if (isset($_POST['update'])) {
    $id = $_POST['id_dokter'];
    $nama = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];
    mysqli_query($conn, "UPDATE dokter SET nama_dokter='$nama', spesialisasi='$spesialisasi' WHERE id_dokter=$id");
    echo "<script>alert('Data dokter diperbarui!'); window.location='dokter.php';</script>";
}

// Hapus Dokter
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM dokter WHERE id_dokter=$id");
    echo "<script>alert('Data dokter dihapus!'); window.location='dokter.php';</script>";
}

// Ambil data
$result = mysqli_query($conn, "SELECT * FROM dokter ORDER BY id_dokter ASC");

// Ambil data untuk edit
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM dokter WHERE id_dokter=$id"));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Dokter</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-secondary {
            background-color: #f44336;
        }
        .btn-secondary:hover {
            background-color: #d32f2f;
        }
        .form-container {
            margin-top: 20px;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .nav {
            margin-bottom: 20px;
            text-align: center;
        }
        .nav a {
            margin: 0 10px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #2196F3;
            color: white;
            border-radius: 5px;
        }
        .nav a:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <a href="index.php">Data Pasien</a>
        <a href="dokter.php">Data Dokter</a>
    </div>

    <h2>Data Dokter</h2>

    <?php if (!$edit): ?>
        <button class="btn" onclick="document.getElementById('formDokter').style.display='block'">+ Tambah Dokter</button>
    <?php endif; ?>

    <!-- FORM TAMBAH / EDIT -->
    <div id="formDokter" class="form-container" style="<?= $edit ? '' : 'display:none;' ?>">
        <form method="post">
            <?php if ($edit): ?>
                <input type="hidden" name="id_dokter" value="<?= $edit['id_dokter'] ?>">
                <label>Nama Dokter:</label>
                <input type="text" name="nama_dokter" value="<?= $edit['nama_dokter'] ?>" required>
                <label>Spesialisasi:</label>
                <input type="text" name="spesialisasi" value="<?= $edit['spesialisasi'] ?>" required>
                <button class="btn" type="submit" name="update">Simpan Perubahan</button>
                <a class="btn btn-secondary" href="dokter.php">Batal</a>
            <?php else: ?>
                <label>Nama Dokter:</label>
                <input type="text" name="nama_dokter" required>
                <label>Spesialisasi:</label>
                <input type="text" name="spesialisasi" value="Umum" required>
                <button class="btn" type="submit" name="tambah">Simpan Dokter</button>
                <button class="btn btn-secondary" type="button" onclick="document.getElementById('formDokter').style.display='none'">Batal</button>
            <?php endif; ?>
        </form>
    </div>

    <!-- TABEL DOKTER -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Dokter</th>
                <th>Spesialisasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $row['id_dokter'] ?></td>
                <td><?= htmlspecialchars($row['nama_dokter']) ?></td>
                <td><?= $row['spesialisasi'] ?></td>
                <td>
                    <a class="btn" href="dokter.php?edit=<?= $row['id_dokter'] ?>">✏️ Edit</a>
                    <a class="btn btn-secondary" href="dokter.php?hapus=<?= $row['id_dokter'] ?>" onclick="return confirm('Yakin ingin hapus?')">🗑️ Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html></td></td>
