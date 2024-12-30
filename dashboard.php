<?php
session_start();
include('db_connection.php'); // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan sanitasi input
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);
    
    // Parameterized query untuk memeriksa username
    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        $roleRedirect = [
            'Petugas Gudang' => 'petugas_gudang_dashboard.php',
            'Petugas Kasir' => 'petugas_kasir_dashboard.php',
            'Pemilik Toko' => 'pemilik_toko_dashboard.php',
        ];
        if (isset($roleRedirect[$user['role']])) {
            header("Location: " . $roleRedirect[$user['role']]);
            exit();
        } else {
            // Jika role tidak valid
            header("Location: login.php?error=invalid_role");
            exit();
        }
    } else {
        // Jika login gagal
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan username dan role
$username = htmlspecialchars($_SESSION['username']);
$role = htmlspecialchars($_SESSION['role']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Inventori Toko</title>
    <style>
        /* Styling untuk halaman dashboard */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(191, 166, 138); /* Warna nude estetik */
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #8b6f47; /* Warna coklat lembut */
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fffaf3; /* Warna krem lembut */
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #8b6f47; /* Warna coklat lembut */
        }

        .role-container {
            margin-top: 20px;
            text-align: center;
        }

        .role-container h2 {
            font-size: 24px;
            color: #8b6f47; /* Warna coklat lembut */
        }

        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .content p {
            font-size: 18px;
            color: #555;
        }

        .dashboard-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color:rgb(98, 62, 13); /* Warna biru untuk tombol dashboard */
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .dashboard-btn:hover {
            background-color:rgb(202, 183, 157); /* Warna biru lebih gelap untuk hover */
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
       <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h1>Selamat datang di Sistem Inventori Toko, <?php echo $username; ?>!</h1>

        <!-- Konten berdasarkan role -->
        <div class="role-container">
            <?php if ($role == 'Petugas Gudang') { ?>
                <div class="content">
                    <h2>Dashboard Petugas Gudang</h2>
                    <p>Halo, Petugas Gudang! Di sini Anda dapat mengelola stok barang yang masuk ke gudang.</p>
                    <a href="petugas_gudang_dashboard.php" class="dashboard-btn">Ke Dashboard Petugas Gudang</a>
                </div>
            <?php } elseif ($role == 'Petugas Kasir') { ?>
                <div class="content">
                    <h2>Dashboard Petugas Kasir</h2>
                    <p>Halo, Petugas Kasir! Di sini Anda dapat mencatat transaksi penjualan dan memproses pembayaran.</p>
                    <a href="petugas_kasir_dashboard.php" class="dashboard-btn">Ke Dashboard Petugas Kasir</a>
                </div>
            <?php } elseif ($role == 'Pemilik Toko') { ?>
                <div class="content">
                    <h2>Dashboard Pemilik Toko</h2>
                    <p>Halo, Pemilik Toko! Di sini Anda dapat melihat laporan dan mengelola toko Anda.</p>
                    <a href="pemilik_toko_dashboard.php" class="dashboard-btn">Ke Dashboard Pemilik Toko</a>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>
