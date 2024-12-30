<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventori_toko";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
