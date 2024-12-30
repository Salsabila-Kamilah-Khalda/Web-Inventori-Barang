<?php
session_start();
include('db_connection.php');

if ($_SESSION['role'] != 'Pemilik Toko') {
    die("Akses ditolak");
}

$query = "SELECT * FROM barang WHERE stok < minimumStok";
$result = mysqli_query($conn, $query);

echo "<h3>Barang dengan Stok Hampir Habis</h3>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "Kode Barang: " . $row['kodeBarang'] . " - Nama Barang: " . $row['namaBarang'] . " - Stok: " . $row['stok'] . "<br>";
}
?>
