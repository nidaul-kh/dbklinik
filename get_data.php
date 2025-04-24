<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input
    if (!isset($_POST["type"])) {
        die("Error: Type parameter is required");
    }
    
    $type = $_POST["type"];
    $no_norm = isset($_POST["no_norm"]) ? $_POST["no_norm"] : null;
    $html = '';
    $no = 1;

    try {
        if ($type == "rekam") {
            if (!$no_norm) die("Error: no_norm is required for rekam type");
            
            $sql = "SELECT * FROM rekam_medis WHERE no_norm = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $no_norm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $html .= "<tr>
                    <td>$no</td>
                    <td>{$row['id_rekam']}</td>
                    <td>{$row['no_norm']}</td>
                    <td>{$row['tanggal_kunjungan']}</td>
                    <td>{$row['diagnosis']}</td>
                    <td>{$row['tindakan']}</td>
                    <td>{$row['dokter']}</td>
                    <td>
                        <a href='edit_data.php?id={$row['id_rekam']}'>Edit</a> | 
                        <a href='hapus_data.php?id={$row['id_rekam']}'>Hapus</a> 
                    </td>
                </tr>";
                $no++;
            }
            $stmt->close();
        }
        elseif ($type == 'obat') {
            if (!$no_norm) die("Error: no_norm is required for obat type");
            
            $sql = "SELECT o.* FROM obat o 
                    JOIN rekam_medis r ON o.id_rekam = r.id_rekam 
                    WHERE r.no_norm = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $no_norm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $html .= "<tr>
                    <td>$no</td>
                    <td>{$row['id_obat']}</td>
                    <td>{$row['id_rekam']}</td>
                    <td>{$row['nama_obat']}</td>
                    <td>{$row['dosis']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>
                        <a href='edit_obat.php?id={$row['id_obat']}'>Edit</a> | 
                        <a href='hapus_obat.php?id={$row['id_obat']}'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            $stmt->close();
        }
        elseif ($type == "pembayaran") {
            if (!$no_norm) die("Error: no_norm is required for pembayaran type");
            
            $sql = "SELECT * FROM pembayaran WHERE no_norm = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $no_norm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $html .= "<tr>
                    <td>$no</td>
                    <td>{$row['id_pembayaran']}</td>
                    <td>{$row['no_norm']}</td>
                    <td>{$row['tanggal_pembayaran']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>{$row['metode_pembayaran']}</td>
                    <td>
                        <a href='edit_pembayaran.php?id={$row['id_pembayaran']}'>Edit</a> | 
                        <a href='hapus_pembayaran.php?id={$row['id_pembayaran']}'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            $stmt->close();
        }
        else {
            die("Error: Invalid type parameter");
        }

        echo $html;
    } catch (Exception $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Error: Invalid request method");
}

$conn->close();
?>