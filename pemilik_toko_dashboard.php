<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki role 'Pemilik Toko'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Pemilik Toko') {
    header("Location: login.php");
    exit();
}

// Mendapatkan data session
$username = $_SESSION['username'];

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'inventori_toko';
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan total penjualan
$sql_total_penjualan = "SELECT SUM(qty) AS total_penjualan FROM transaksi";
$result_total_penjualan = $conn->query($sql_total_penjualan);
$row_total_penjualan = $result_total_penjualan->fetch_assoc();
$total_penjualan = $row_total_penjualan['total_penjualan'] ?? 0;

// Query untuk mendapatkan stok tersedia
$sql_stok_tersedia = "SELECT SUM(stok) AS stok_tersedia FROM barang";
$result_stok_tersedia = $conn->query($sql_stok_tersedia);
$row_stok_tersedia = $result_stok_tersedia->fetch_assoc();
$stok_tersedia = $row_stok_tersedia['stok_tersedia'] ?? 0;

// Query untuk mendapatkan pesanan baru (misalnya transaksi dalam 30 hari terakhir)
$sql_pesanan_baru = "SELECT COUNT(*) AS pesanan_baru FROM transaksi WHERE tanggal > DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)";
$result_pesanan_baru = $conn->query($sql_pesanan_baru);
$row_pesanan_baru = $result_pesanan_baru->fetch_assoc();
$pesanan_baru = $row_pesanan_baru['pesanan_baru'] ?? 0;

// Query untuk mendapatkan keuntungan bulanan
$sql_keuntungan_bulanan = "SELECT SUM(qty * hargaJual) AS keuntungan_bulanan FROM transaksi WHERE MONTH(tanggal) = MONTH(CURRENT_DATE)";
$result_keuntungan_bulanan = $conn->query($sql_keuntungan_bulanan);
$row_keuntungan_bulanan = $result_keuntungan_bulanan->fetch_assoc();
$keuntungan_bulanan = $row_keuntungan_bulanan['keuntungan_bulanan'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik Toko - Sistem Inventori Toko</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8e9d2; /* Warna nude yang lembut */
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ba9b87; /* Coklat muda elegan */
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 3px solid #856c5e;
        }

        .container {
            margin: 50px;
            padding: 30px;
            background-color: rgba(54, 21, 2, 0.9); /* Warna background kontainer */
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .welcome-message {
            font-size: 20px;
            margin-bottom: 30px;
            color: #8b6f47; /* Warna teks lembut */
            text-align: center;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 30px;
        }

        .stats div {
            background-color: #ba9b87; /* Coklat muda */
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: 23%;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .stats div:hover {
            background-color: #856c5e; /* Coklat lebih gelap saat hover */
            transform: translateY(-5px);
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            margin-top: 30px;
            gap: 80px;
        }

        .menu a {
            display: block;
            background-color: #ba9b87; /* Coklat muda */
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            text-align: center;
            border-radius: 50px;
            width: 180px;
            margin-bottom: 15px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .menu a:hover {
            background-color: #856c5e;
            transform: translateY(-5px);
        }

        .logout-btn {
            display: block;
            background-color: #f44336; /* Merah untuk logout */
            color: white;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            width: 180px;
            margin-top: 30px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #e53935;
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .menu a {
                width: 150px;
            }
            .stats div {
                width: 48%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Pemilik Toko</h1>
</header>

<div class="container">
    <div class="welcome-message">
        <h2>Selamat datang, <?php echo htmlspecialchars($username); ?> </h2>
        <h3>Anda login sebagai Pemilik Toko</h3>
    </div>

    <!-- Statistik Toko -->
    <div class="stats">
        <div>
            <h3>Total Penjualan</h3>
            <p><?php echo $total_penjualan; ?> Barang</p>
        </div>
        <div>
            <h3>Stok Tersedia</h3>
            <p><?php echo $stok_tersedia; ?> Barang</p>
        </div>
        <div>
            <h3>Pesanan Baru</h3>
            <p><?php echo $pesanan_baru; ?> Pesanan</p>
        </div>
        <div>
            <h3>Keuntungan Bulanan</h3>
            <p>Rp <?php echo number_format($keuntungan_bulanan, 0, ',', '.'); ?></p>
        </div>
    </div>

    <!-- Menu Aksi -->
    <div class="menu">
        <a href="stok_hampir_habis.php">Stok Hampir Habis</a>
        <a href="edit_batas_stok.php">Edit Batas Minimum Stok</a>
        <a href="edit_harga_jual.php">Edit Harga Jual Barang</a>
        <a href="daftar_barang.php">Daftar Barang</a>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
