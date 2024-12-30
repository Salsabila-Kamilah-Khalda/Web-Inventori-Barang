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

// Proses update batas stok jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kodeBarang = $_POST['kodeBarang'];
    $minimumStok = $_POST['minimumStok'];

    $updateQuery = "UPDATE barang SET minimumStok = ? WHERE kodeBarang = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $minimumStok, $kodeBarang);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $message = "Batas stok berhasil diperbarui.";
        } else {
            $message = "Batas stok gagal diperbarui. Periksa kode barang.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

// Ambil data barang untuk ditampilkan
$query = "SELECT kodeBarang, namaBarang, stok, minimumStok FROM barang";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Batas Stok Barang</title>
    <style>
        /* Styling halaman */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(210, 189, 176);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color:rgb(148, 122, 105);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color:rgb(255, 255, 254);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: rgb(38, 23, 0);
            color:rgb(255, 255, 255);
        }

        tr.low-stock {
            background-color:rgb(210, 189, 176);/
        }

        tr:hover {
            background-color:rgb(210, 189, 176); /* Efek hover */
        }

        .form-container {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, button {
            background-color:rgb(210, 189, 176);
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color:rgb(38, 23, 0);
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color:rgb(210, 189, 176);
        }

        .message {
            text-align: center;
            font-size: 14px;
            color: #333;
            margin-bottom: 20px;
        }

        .low-stock-label {
            color: #d32f2f;
            font-weight: bold;
        }
        
        a {
            display: inline-block;
            text-decoration: none;
            background-color: rgb(148, 122, 105);
            color: black;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        a:hover {
            background-color: rgb(210, 189, 176);
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Batas Stok Barang</h1>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Stok Saat Ini</th>
                    <th>Batas Minimum</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="<?php echo ($row['stok'] <= $row['minimumStok']) ? 'low-stock' : ''; ?>">
                        <td><?php echo htmlspecialchars($row['kodeBarang']); ?></td>
                        <td><?php echo htmlspecialchars($row['namaBarang']); ?></td>
                        <td><?php echo htmlspecialchars($row['stok']); ?></td>
                        <td><?php echo htmlspecialchars($row['minimumStok']); ?></td>
                        <td>
                            <?php if ($row['stok'] <= $row['minimumStok']): ?>
                                <span class="low-stock-label">Stok Hampir Habis</span>
                            <?php else: ?>
                                Stok Aman
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="form-container">
            <form method="POST" action="edit_batas_stok.php">
                <label for="kodeBarang">Kode Barang:</label>
                <input type="text" id="kodeBarang" name="kodeBarang" required>

                <label for="minimumStok">Batas Minimum Stok Baru:</label>
                <input type="number" id="minimumStok" name="minimumStok" required>

                <button type="submit">Perbarui</button>
            </form>
        </div>
    </div>

    <?php
    // Tutup koneksi
    mysqli_close($conn);
    ?>
        <div class="back-btn">
            <a href="pemilik_toko_dashboard.php">Kembali ke Dashboard</a>
        </div>
</body>
</html>
