<?php
session_start();
require_once('data.php');

// Mulai session dan termasukkan file dbconnect.php untuk koneksi ke database
require_once "dbconnect.php";

// Jika form login dikirim
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi atau proses login sesuai kebutuhan
    
    // Contoh: Periksa apakah username dan password cocok dengan data yang ada di database
    $query = "SELECT * FROM login WHERE username=? AND password=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        // Login berhasil, atur session
        $_SESSION['username'] = $username;
        $_SESSION['login'] = true;
        
        // Redirect ke halaman beranda atau halaman lain yang diinginkan setelah login
        header('Location: index.php');
        exit; // Penting untuk menghentikan eksekusi script selanjutnya setelah melakukan redirect
    } else {
        // Login gagal, bisa ditambahkan pesan kesalahan atau langkah lainnya
        echo "Username atau password salah.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url(bg\ 2.jpg);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-msg {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
    
<div class="container">
    <div class="login-container">
        <h2>Login</h2>
        <?php
        if(isset($_SESSION['login_error'])) {
            echo '<div class="error-msg">Username atau password salah.</div>';
            unset($_SESSION['login_error']); // Hapus session error setelah ditampilkan
        }
        ?>
        <form method="post" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Login">
            </div>
        </form>
        <?php
        if(isset($error_msg)) {
            echo '<div class="error-msg">'.$error_msg.'</div>';
        }
        ?>
        <div class="form-group">
            <p>Belum memiliki akun? <a href="registrasi.php">Daftar di sini</a></p>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
