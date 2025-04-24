<?php
include 'koneksi.php';

$sql = "SELECT * FROM obat";
$result = $conn->query($sql);
$no = 1;

while ($row = $result->fetch_assoc()) {
    echo "<tr>
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

$conn->close();
?>