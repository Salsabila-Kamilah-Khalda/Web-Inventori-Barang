<?php
// Koneksi ke database
$host = 'localhost'; // Host database
$user = 'root'; // Username database
$password = ''; // Password database
$database = 'inventori_toko'; // Nama database

$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Proses update harga jual jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kodeBarang = $_POST['kodeBarang'];
    $hargaJualBaru = $_POST['hargaJualBaru'];

    $query = "UPDATE barang SET hargaJual = ? WHERE kodeBarang = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ds", $hargaJualBaru, $kodeBarang);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Harga jual berhasil diperbarui.";
        } else {
            $message = "Gagal memperbarui harga jual: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Gagal mempersiapkan query: " . mysqli_error($conn);
    }
}

// Ambil data barang untuk ditampilkan di dropdown
$query = "SELECT kodeBarang, namaBarang, hargaJual FROM barang";
$result = mysqli_query($conn, $query);

// Tutup koneksi jika tidak diperlukan lagi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Harga Jual</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(171, 156, 140); /* Warna latar nude */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            padding: 20px;
            background: #fffaf3; /* Warna putih dengan sedikit krem */
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #8b6f47; /* Warna coklat lembut */
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #5e4b3a; /* Warna coklat lebih gelap */
        }

        select, input {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0d8c6; /* Warna krem pucat */
            border-radius: 6px;
            background-color: #fdfaf6; /* Warna krem terang */
            font-size: 14px;
            color: #5e4b3a;
        }

        select:focus, input:focus {
            outline: none;
            border-color: #d6bea4; /* Warna fokus */
        }

        button {
            width: 100%;
            padding: 10px;
            background: rgb(120, 90, 58); /* Warna coklat muda */
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background: rgb(171, 156, 140); /* Warna coklat lebih gelap */
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #5e4b3a; /* Warna teks pesan */
        }

        .message.success {
            color: #8b6f47; /* Warna pesan sukses */
        }

        .message.error {
            color: #c24a4a; /* Warna pesan error */
        }

        .back-btn {
            margin-top: 20px;
            text-align: center;
        }

        .back-btn a {
            display: inline-block;
            text-decoration: none;
            background-color: rgb(120, 90, 58);; /* Warna coklat nude */
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .back-btn a:hover {
            background-color: rgb(171, 156, 140); /* Warna hover */
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Harga Jual</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="kodeBarang">Pilih Barang</label>
                <select name="kodeBarang" id="kodeBarang" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <option value="<?php echo htmlspecialchars($row['kodeBarang']); ?>">
                                <?php echo htmlspecialchars($row['namaBarang'] . " - Rp " . number_format($row['hargaJual'], 2)); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hargaJualBaru">Harga Jual Baru</label>
                <input type="number" step="0.01" name="hargaJualBaru" id="hargaJualBaru" required>
            </div>
            <button type="submit">Simpan Perubahan</button>
        </form>

        <?php if (isset($message)): ?>
            <div class="message <?php echo strpos($message, 'berhasil') !== false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="back-btn">
            <a href="pemilik_toko_dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
