<?php
session_start();
include('db_connection.php');

// Cek apakah role user adalah 'Petugas Gudang'
if ($_SESSION['role'] != 'Petugas Gudang') {
    // Jika akses ditolak, tampilkan halaman dengan latar belakang nude
    echo '<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Akses Ditolak</title>
        <style>
            body {
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                background-color: rgb(191, 166, 138); /* Warna nude estetik */
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                text-align: center;
            }

            .container {
                background-color: #fffaf3; /* Warna krem lembut */
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                max-width: 600px;
            }

            h1 {
                color: #8b6f47; /* Warna coklat lembut */
                font-size: 24px;
            }

            p {
                color: #8b6f47;
                font-size: 18px;
            }

            .btn-back {
                display: inline-block;
                padding: 10px 20px;
                background-color: rgb(191, 166, 138);
                color: white;
                text-decoration: none;
                border-radius: 6px;
                font-weight: bold;
                margin-top: 20px;
                text-align: center;
                transition: background-color 0.3s ease;
            }

            .btn-back:hover {
                background-color: rgb(219, 213, 206);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Akses Ditolak</h1>
            <p>Anda tidak memiliki hak akses untuk halaman ini.</p>';
            
            // Redirect berdasarkan role
            if ($_SESSION['role'] == 'Petugas Kasir') {
                echo '<a href="petugas_kasir_dashboard.php" class="btn-back">Kembali ke Dashboard Petugas Kasir</a>';
            } elseif ($_SESSION['role'] == 'Pemilik Toko') {
                echo '<a href="pemilik_toko_dashboard.php" class="btn-back">Kembali ke Dashboard Pemilik Toko</a>';
            }

            echo '</div>
    </body>
    </html>';
    exit(); // Menghentikan eksekusi lebih lanjut
}
?>

<!-- Form Submit and Stok Update -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign the values from POST
    $kodeBarang = mysqli_real_escape_string($conn, $_POST['kodeBarang']);
    $namaBarang = mysqli_real_escape_string($conn, $_POST['namaBarang']);
    $jenisBarang = mysqli_real_escape_string($conn, $_POST['jenisBarang']);
    $hargaBeli = mysqli_real_escape_string($conn, $_POST['hargaBeli']);
    $hargaJual = mysqli_real_escape_string($conn, $_POST['hargaJual']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);
    $minimumStok = mysqli_real_escape_string($conn, $_POST['minimumStok']);

    // Cek apakah barang dengan kode yang sama sudah ada
    $query_check = "SELECT stok FROM barang WHERE kodeBarang = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, "s", $kodeBarang);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Jika barang sudah ada, update stok yang ada
        $row = mysqli_fetch_assoc($result_check);
        $new_stok = $row['stok'] + $stok;  // Tambah stok yang ada dengan stok yang baru

        $query_update = "UPDATE barang SET stok = ? WHERE kodeBarang = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "is", $new_stok, $kodeBarang);
        
        if (mysqli_stmt_execute($stmt_update)) {
            echo "Stok barang berhasil diperbarui!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Jika barang belum ada, tambahkan barang baru
        $query_insert = "INSERT INTO barang (kodeBarang, namaBarang, jenisBarang, hargaBeli, hargaJual, stok, minimumStok) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "ssssdis", $kodeBarang, $namaBarang, $jenisBarang, $hargaBeli, $hargaJual, $stok, $minimumStok);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            echo "Barang berhasil ditambahkan!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(191, 166, 138); /* Warna nude estetik */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fffaf3; /* Warna krem lembut */
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #8b6f47; /* Warna coklat lembut */
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 16px;
            width: 100%;
            background: rgb(191, 166, 138);
        }

        button {
            padding: 10px;
            background-color: rgb(191, 166, 138); /* Warna coklat muda */
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: rgb(219, 213, 206); /* Warna coklat lebih gelap */
        }

        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgb(191, 166, 138);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: rgb(219, 213, 206);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>

        <!-- Form tambah barang -->
        <form method="POST" action="tambah_barang.php">
            Kode Barang: <input type="text" name="kodeBarang" required><br>
            Nama Barang: <input type="text" name="namaBarang" required><br>
            Jenis Barang: <input type="text" name="jenisBarang" required><br>
            Harga Beli: <input type="text" name="hargaBeli" required><br>
            Harga Jual: <input type="text" name="hargaJual" required><br>
            Stok: <input type="number" name="stok" required><br>
            Minimum Stok: <input type="number" name="minimumStok" required><br>
            <button type="submit">Tambah Barang</button>
        </form>

        <!-- Tombol Kembali ke Dashboard -->
        <a href="petugas_gudang_dashboard.php" class="btn-back">Kembali ke Dashboard</a>
    </div>
</body>
</html>
