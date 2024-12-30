<?php
// Start the session at the beginning of the script
session_start();

// Koneksi ke database
$host = 'localhost'; // Sesuaikan dengan konfigurasi server Anda
$user = 'root'; // Username database
$password = ''; // Password database
$database = 'inventori_toko'; // Nama database
$role = $_SESSION['role']; // Pastikan Anda sudah menetapkan role dalam session sebelumnya

$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Query untuk mengambil semua data barang
$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <style>
        /* Styling untuk halaman daftar barang */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(126, 112, 81); /* Warna latar nude */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background: #fffaf3; /* Warna krem lembut */
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #8b6f47; /* Warna coklat lembut */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #e0d8c6; /* Warna krem pucat */
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: rgb(174, 143, 118); /* Warna teks coklat gelap */
        }

        th {
            background-color: #d6bea4; /* Warna coklat muda */
            color: white; /* Teks putih untuk header */
        }

        tr:nth-child(even) {
            background-color: #fdfaf6; /* Warna krem terang */
        }

        tr:hover {
            background-color: #f3e9dd; /* Warna krem lembut untuk hover */
        }

        .no-data {
            text-align: center;
            font-size: 16px;
            color: #888;
            margin-top: 20px;
        }

        .btn-add {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #d6bea4; /* Warna coklat muda */
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-add:hover {
            background-color: #c5a986; /* Warna coklat lebih gelap */
        }

        .btn-back {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #d6bea4; /* Warna coklat muda */
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #c5a986; /* Warna coklat lebih gelap */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Barang</h1>
        <a href="tambah_barang.php" class="btn-add">Tambah Barang</a> <!-- Link untuk menambah barang -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Minimum Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['kodeBarang']); ?></td>
                            <td><?php echo htmlspecialchars($row['namaBarang']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenisBarang']); ?></td>
                            <td>Rp <?php echo number_format($row['hargaBeli'], 2, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($row['hargaJual'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['stok']); ?></td>
                            <td><?php echo htmlspecialchars($row['minimumStok']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">Tidak ada barang dalam daftar.</div>
        <?php endif; ?>

        <?php
        // Tutup koneksi
        mysqli_close($conn);
        ?>
    </div>

    <!-- Tombol Kembali ke Dashboard -->
    <?php if ($role == 'Pemilik Toko'): ?>
    <a href="pemilik_toko_dashboard.php" class="btn-back">Kembali ke Dashboard Pemilik Toko</a>
    <?php elseif ($role == 'Petugas Gudang'): ?>
    <a href="petugas_gudang_dashboard.php" class="btn-back">Kembali ke Dashboard Petugas Gudang</a>
    <?php elseif ($role == 'Petugas Kasir'): ?>
    <a href="petugas_kasir_dashboard.php" class="btn-back">Kembali ke Dashboard Petugas Kasir</a>
    <?php else: ?>
    <a href="login.php" class="btn-back">Login terlebih dahulu</a>
    <?php endif; ?>
</body>
</html>
