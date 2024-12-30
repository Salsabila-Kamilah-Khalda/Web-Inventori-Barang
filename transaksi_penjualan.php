<?php
session_start();
include('db_connection.php');

if ($_SESSION['role'] != 'Petugas Kasir') {
    die("Akses ditolak");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomorNota = $_POST['nomorNota'];
    $kodeBarang = $_POST['kodeBarang'];
    $qty = $_POST['qty'];
    $hargaJual = $_POST['hargaJual'];
    $tanggal = date('Y-m-d');
    
    // Update stok barang
    $queryStok = "UPDATE barang SET stok = stok - $qty WHERE kodeBarang = '$kodeBarang'";
    mysqli_query($conn, $queryStok);
    
    // Insert transaksi penjualan
    $queryTransaksi = "INSERT INTO transaksi (nomorNota, tanggal, kodeBarang, qty, hargaJual)
                       VALUES ('$nomorNota', '$tanggal', '$kodeBarang', '$qty', '$hargaJual')";
    if (mysqli_query($conn, $queryTransaksi)) {
        echo "<p style='color: green; text-align: center;'>Transaksi berhasil!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8e9d2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fffaf3;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        .container h2 {
            color: #856c5e;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #d6bea4;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            background-color: #ba9b87;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #856c5e;
        }

        .back-button {
            background-color: #d6bea4;
            margin-top: 15px;
        }

        .back-button:hover {
            background-color: #c5a986;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Catat Transaksi Penjualan</h2>
    <form method="POST" action="transaksi_penjualan.php">
        Nomor Nota: <br><input type="text" name="nomorNota" required><br>
        Kode Barang: <br><input type="text" name="kodeBarang" required><br>
        Qty: <br><input type="number" name="qty" required><br>
        Harga Jual: <br><input type="text" name="hargaJual" required><br>
        <button type="submit">Catat Transaksi</button>
    </form>
    <a href="petugas_kasir_dashboard.php">
        <button class="back-button">Kembali ke Dashboard</button>
    </a>
</div>

</body>
</html>
