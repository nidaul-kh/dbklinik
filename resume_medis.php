<?php
include 'koneksi.php';

// Tambah data
if (isset($_POST['tambah'])) {
    $no_norm = $_POST['no_norm'];
    $tanggal = $_POST['tanggal_kunjungan'];
    $diagnosis = $_POST['diagnosis'];
    $tindakan = $_POST['tindakan'];
    $dokter = $_POST['dokter'];

    $query = "INSERT INTO rekam_medis (no_norm, tanggal_kunjungan, diagnosis, tindakan, dokter)
              VALUES ('$no_norm', '$tanggal', '$diagnosis', '$tindakan', '$dokter')";
    mysqli_query($conn, $query);
    echo "<script>alert('Resume berhasil ditambahkan!'); window.location='resume_medis.php';</script>";
}

// Edit data
if (isset($_POST['update'])) {
    $no_norm = $_POST['no_norm'];  // Update untuk no_norm
    $tanggal = $_POST['tanggal_kunjungan'];
    $diagnosis = $_POST['diagnosis'];
    $tindakan = $_POST['tindakan'];
    $dokter = $_POST['dokter'];

    $query = "UPDATE rekam_medis SET tanggal_kunjungan='$tanggal', diagnosis='$diagnosis', 
              tindakan='$tindakan', dokter='$dokter' WHERE no_norm='$no_norm'";  // Ganti id_rekam menjadi no_norm
    mysqli_query($conn, $query);
    echo "<script>alert('Resume berhasil diubah!'); window.location='resume_medis.php';</script>";
}

// Hapus data
if (isset($_GET['hapus'])) {
    $no_norm = $_GET['hapus'];  // Ganti id_rekam menjadi no_norm
    mysqli_query($conn, "DELETE FROM rekam_medis WHERE no_norm='$no_norm'");  // Ganti id_rekam menjadi no_norm
    echo "<script>alert('Resume berhasil dihapus!'); window.location='resume_medis.php';</script>";
}

// Ambil data untuk ditampilkan
$result = mysqli_query($conn, "SELECT 
    pasien.no_norm, pasien.nama_pasien, pasien.jk, pasien.tgl_lahir, rekam_medis.dokter 
    FROM rekam_medis 
    JOIN pasien ON rekam_medis.no_norm = pasien.no_norm");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Medis</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Style untuk halaman */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            padding: 15px 20px;
            color: white;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        /* Form tambah/edit */
        .form-tambah {
            display: none;
            flex-wrap: wrap;
            gap: 15px;
        }
        .form-tambah label {
            flex: 1;
            font-size: 14px;
        }
        .form-tambah input, .form-tambah select, .form-tambah textarea {
            flex: 2;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .form-actions button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-actions button:hover {
            background-color: #45a049;
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
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-edit, .btn-delete {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-edit:hover {
            background-color: #45a049;
        }
        .btn-delete:hover {
            background-color: #e53935;
        }
    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById('formTambah');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'flex' : 'none';
        }

        function cancelForm() {
            document.getElementById('formTambah').style.display = 'none';
        }
    </script>
</head>
<body>

<header>
    <h1>Resume Medis Pasien</h1>
</header>

<div class="container">
    <!-- Tombol untuk menampilkan form tambah -->
    <button onclick="toggleForm()">Tambah Resume</button>
    <button class="tab-btn" onclick="window.location.href='index.php'">Data Pasien</button>
    <button class="tab-btn" onclick="window.location.href='dokter.php'">Data Dokter</button>

    <!-- FORM TAMBAH -->
    <form method="post" class="form-tambah" id="formTambah">
        <label for="no_norm">No. Rekam Medis (Norm):</label>
        <select name="no_norm" required>
            <option value="">--Pilih Pasien--</option>
            <?php
            $pasien = mysqli_query($conn, "SELECT * FROM pasien");
            while ($p = mysqli_fetch_assoc($pasien)) {
                echo "<option value='{$p['no_norm']}'>{$p['no_norm']} - {$p['nama_pasien']}</option>";
            }
            ?>
        </select>

        <label for="tanggal_kunjungan">Tanggal Kunjungan:</label>
        <input type="date" name="tanggal_kunjungan" required>
        
        <label for="diagnosis">Diagnosis:</label>
        <textarea name="diagnosis" required></textarea>
        
        <label for="tindakan">Tindakan:</label>
        <textarea name="tindakan"></textarea>
        
        <label for="dokter">Dokter:</label>
        <input type="text" name="dokter" required>
        
        <div class="form-actions">
            <button type="submit" name="tambah">Tambah Resume</button>
            <button type="button" onclick="cancelForm()">Batal</button>
        </div>
    </form>

    <!-- TABEL RESUME MEDIS -->
    <table>
        <thead>
            <tr>
                <th>No. Rekam Medis</th>
                <th>Nama Pasien</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Nama Dokter</th>
                <th>Spesialisasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $row['no_norm'] ?></td>
                    <td><?= $row['nama_pasien'] ?></td>
                    <td><?= $row['jk'] ?></td>
                    <td><?= $row['tgl_lahir'] ?></td>
                    <td><?= $row['dokter'] ?></td>
                    <td>Umum</td> <!-- Replace 'Umum' with actual specialization if available -->
                    <td>
                        <a href="resume_medis.php?edit=<?= $row['no_norm'] ?>" class="btn-edit">Edit</a> |
                        <a href="resume_medis.php?hapus=<?= $row['no_norm'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn-delete">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
