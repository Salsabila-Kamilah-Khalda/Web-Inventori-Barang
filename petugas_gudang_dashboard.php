<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki role 'Petugas Gudang'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Petugas Gudang') {
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
    <title>Dashboard Petugas Gudang - Sistem Inventori Toko</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdf5e6; /* Warna nude */
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #8b5e3c; /* Warna coklat estetik */
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }

        .container {
            margin: 20px;
            background: #fff7ef; /* Warna nude terang */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #5a3c2c; /* Warna teks coklat lembut */
        }

        .menu {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .menu a {
            display: block;
            background-color: #8b5e3c; /* Warna coklat estetik */
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            width: 220px;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
        }

        .menu a:hover {
            background-color: #734d2c; /* Warna coklat lebih gelap */
            transform: translateY(-3px);
        }

        .logout-btn {
            display: block;
            background-color: #d9534f; /* Warna merah lembut */
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            width: 220px;
            margin: 20px auto 0;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c9302c;
            transform: translateY(-3px);
        }

        @media (max-width: 600px) {
            .menu {
                flex-direction: column;
                align-items: center;
            }

            .menu a {
                margin-bottom: 15px;
                width: 100%;
            }

            .logout-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Dashboard Petugas Gudang</h1>
</header>

<div class="container">
    <div class="welcome-message">
        <p>Selamat datang, <?php echo htmlspecialchars($username); ?>!</p>
        <p>Anda login sebagai Petugas Gudang.</p>
    </div>

    <div class="menu">
        <a href="tambah_barang.php">Entri Barang Masuk</a>
        <a href="daftar_barang.php">Daftar Barang</a>
    </div>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
