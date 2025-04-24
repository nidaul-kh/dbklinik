<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Sentosa</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
            .marquee {
            background-color: #3b5998;
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 18px;
            overflow: hidden;
            white-space: nowrap;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 15s linear infinite;
        }
        
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #3b5998;
            color: white;
            padding: 15px 20px;
            text-align: center;
            font-size: 24px;
        }

        .tabs-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .tab-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .tab-btn:hover {
            background-color: #45a049;
        }

        .content {
            display: none;
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .active {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
            margin: auto;
        }

        .form-container label {
            font-size: 14px;
        }

        .form-container input,
        .form-container select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-container button {
            align-self: flex-start;
            background-color: #28a745;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        #pesan {
            margin-top: 20px;
            font-size: 16px;
            color: green;
        }

    </style>
</head>
<body>

<div class="marquee">
    <span>Made by Nidaul Khasanah ✨ Made by Nidaul Khasanah ✨ Made by Nidaul Khasanah ✨ Made by Nidaul Khasanah ✨</span>
</div>

<header>
    Klinik Sentosa
</header>

<div class="tabs-container">
    <button class="tab-btn" data-target="#pasien">Data Pasien</button>
    <button class="tab-btn" onclick="window.location.href='tambah_pasien.php'">Tambah Pasien</button>
    <button class="tab-btn" onclick="window.location.href='dokter.php'">Data Dokter</button>
    <a href="resume_medis.php"><button class="tab-btn">Resume Medis</button></a>
</div>

<div id="rekam-btn-container"></div>

<div id="pasien" class="content active">
    <h2>Data Pasien</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No HP</th>
                <th>Tanggal Lahir</th>
                <th>Tempat Lahir</th>
                <th>Aksi</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM pasien";
            $result = $conn->query($sql);
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>$no</td>
                    <td>{$row['no_norm']}</td>
                    <td>{$row['nama_pasien']}</td>
                    <td>{$row['jk']}</td>
                    <td>{$row['no_hp']}</td>
                    <td>{$row['tgl_lahir']}</td>
                    <td>{$row['tempat_lahir']}</td>
                    <td><button class='tab-btn rekam-btn' data-norm='{$row['no_norm']}'>Lihat Rekam Medis</button></td>
                    <td><a href='edit_data.php?id={$row['no_norm']}'>Edit</a> | <a href='hapus_data.php?id={$row['no_norm']}'>Hapus</a></td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>

<div id="rekam" class="content">
    <h2>Rekam Medis Pasien</h2>
    <a href="tambah_rekam.php">
        <button>Tambah Rekam Medis</button>
    </a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Rekam</th>
                <th>No. RM</th>
                <th>Tanggal</th>
                <th>Diagnosis</th>
                <th>Tindakan</th>
                <th>Dokter</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="rekam-data"></tbody>
    </table>
</div>

<div id="obat" class="content">
    <h2>Riwayat Obat</h2>
    <a href="tambah_obat.php">
        <button>Tambah Obat</button>
    </a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Obat</th>
                <th>ID rekam</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="obat-data"></tbody>
    </table>
</div>

<div id="pembayaran" class="content">
    <h2>Riwayat Pembayaran</h2>
    <a href="tambah_pembayaran.php">
        <button>Tambah Pembayaran</button>
    </a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pembayaran</th>
                <th>No. RM</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="pembayaran-data"></tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $(".tab-btn").click(function() {
            $(".content").removeClass("active").hide();
            $($(this).data("target")).addClass("active").show();
        });

        $(".rekam-btn").click(function() {
            var noNorm = $(this).data("norm");
            
            $.ajax({
                url: "get_data.php",
                type: "POST",
                data: { type: "rekam", no_norm: noNorm },
                success: function(response) {
                    $("#rekam-data").html(response);
                }
            });

            $.ajax({
                url: "get_data.php",
                type: "POST",
                data: { type: "obat", no_norm: noNorm },
                success: function(response) {
                    $("#obat-data").html(response);
                }
            });

            $.ajax({
                url: "get_data.php",
                type: "POST",
                data: { type: "pembayaran", no_norm: noNorm },
                success: function(response) {
                    $("#pembayaran-data").html(response);
                }
            });

            $("#rekam-btn-container").html(
                '<button class="tab-btn" data-target="#obat">Data Obat</button>' +
                '<button class="tab-btn" data-target="#pembayaran">Riwayat Pembayaran</button>'
            );

            $("#rekam-btn-container button").click(function() {
                $(".content").removeClass("active").hide();
                $($(this).data("target")).addClass("active").show();
            });
        });
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
