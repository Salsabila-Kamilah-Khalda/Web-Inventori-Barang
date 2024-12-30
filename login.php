<?php
session_start();
include('db_connection.php'); // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil username dan password dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query untuk memeriksa username yang dimasukkan dengan prepared statement
    $query = "SELECT * FROM pengguna WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
    // Cek apakah user ditemukan dan password valid
    if ($user && $password == $user['password']) { // Cek password langsung tanpa hashing
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect ke halaman dashboard sesuai dengan role
        if ($user['role'] == 'Petugas Gudang') {
            header("Location: dashboard.php");
        } elseif ($user['role'] == 'Petugas Kasir') {
            header("Location: dashboard.php");
        } elseif ($user['role'] == 'Pemilik Toko') {
            header("Location: dashboard.php");
        }
        exit(); // Hentikan eksekusi
    } else {
        // Jika login gagal, redirect kembali ke halaman login dengan error
        header("Location: login.php?error=true");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventori Toko</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            background: linear-gradient(135deg, #f8e9d2 0%, #e6d8c3 100%);
            padding: 0 10px;
        }
        .wrapper {
            width: 400px;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(210, 180, 140, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        .wrapper:hover {
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.25);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        h2 {
            font-size: 2.2rem;
            margin-bottom: 25px;
            color: #856c5e;
            letter-spacing: 1px;
        }
        .input-field {
            position: relative;
            border-bottom: 2px solid rgba(133, 108, 94, 0.3);
            margin: 20px 0;
        }
        .input-field label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            color: #856c5e;
            font-size: 16px;
            pointer-events: none;
            transition: 0.3s ease;
        }
        .input-field input {
            width: 100%;
            height: 40px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #856c5e;
            padding: 0 10px;
        }
        .input-field input:focus ~ label,
        .input-field input:valid ~ label {
            font-size: 0.9rem;
            top: 10px;
            transform: translateY(-150%);
            color: #ba9b87;
        }
        .forget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 35px 0;
            color: #856c5e;
        }
        button {
            background-color: #ba9b87;
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 15px 20px;
            cursor: pointer;
            border-radius: 25px;
            font-size: 16px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #856c5e;
            color: #fff;
        }
        .register {
            text-align: center;
            margin-top: 30px;
            color: #856c5e;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="">
            <h2>Login Sistem Inventori Toko</h2>
            <div class="input-field">
                <input type="text" name="username" required>
                <label>Masukkan Username</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Masukkan Password</label>
            </div>
            <button type="submit">Login</button>
            <div class="register"></div>
        </form>
        <?php
        if (isset($_GET['error'])) {
            echo "<p style='color: red;'>Username atau password salah!</p>";
        }
        ?>
    </div>
</body>
</html>
