<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki role 'Petugas Kasir'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Petugas Kasir') {
    header("Location: login.php");
    exit();
}

// Mendapatkan data session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas Kasir - Sistem Inventori Toko</title>
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            background-color: #f8e9d2;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ba9b87;
            color: white;
            padding: 15px;
            text-align: center;
            border-bottom: 5px solid #856c5e;
        }

        .container {
            margin: 50px;
            padding: 20px;
            background-color: rgba(54, 21, 2, 0.9);
            border-radius: 75px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .welcome-message {
            font-size: 20px;
            margin-bottom: 20px;
            color: rgb(169, 154, 144);
            text-align: center;
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
            background-color: #ba9b87;
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
            background-color: #f44336;
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
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Petugas Kasir</h1>
</header>

<div class="container">
    <div class="welcome-message">
        <h2>Selamat datang, <?php echo htmlspecialchars($username); ?>!</h2>
        <h3>Anda login sebagai Petugas Kasir</h3>
    </div>

    <!-- Menu Aksi -->
    <div class="menu">
        <a href="transaksi_penjualan.php">Catat Transaksi Penjualan</a>
        <a href="daftar_barang.php">Daftar Barang</a>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
