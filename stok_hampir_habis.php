<?php
// Koneksi ke database
$host = 'localhost'; // Sesuaikan dengan konfigurasi server Anda
$user = 'root'; // Username database
$password = ''; // Password database
$database = 'inventori_toko'; // Nama database

$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Query untuk mendapatkan barang dengan stok di bawah minimumStok
$query = "SELECT kodeBarang, namaBarang, jenisBarang, stok, minimumStok FROM barang WHERE stok < minimumStok";
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
    <title>Stok Hampir Habis - Sistem Inventori Toko</title>
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            background-color: #f8e9d2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            background-color: rgba(54, 21, 2, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            color: white;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #fdf5e6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #5a4736;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #ba9b87;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #fdf5e6;
        }

        tr:nth-child(odd) {
            background-color: #f8e9d2;
        }

        tr:hover {
            background-color: #856c5e;
            color: white;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #fdf5e6;
            margin-top: 20px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            background-color: #ba9b87;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        a:hover {
            background-color: #856c5e;
            transform: translateY(-5px);
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Stok Hampir Habis</h1>
        <?php
        // Koneksi ke database
        $conn = mysqli_connect('localhost', 'root', '', 'inventori_toko');

        if (!$conn) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

        $query = "SELECT kodeBarang, namaBarang, jenisBarang, stok, minimumStok FROM barang WHERE stok < minimumStok";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Stok Saat Ini</th>
                        <th>Minimum Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['kodeBarang']); ?></td>
                            <td><?php echo htmlspecialchars($row['namaBarang']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenisBarang']); ?></td>
                            <td><?php echo htmlspecialchars($row['stok']); ?></td>
                            <td><?php echo htmlspecialchars($row['minimumStok']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">Tidak ada barang dengan stok hampir habis.</div>
        <?php endif;

        mysqli_close($conn);
        ?>
        <div class="back-btn">
            <a href="pemilik_toko_dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>

