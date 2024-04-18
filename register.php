<?php
session_start();
require_once "dbconnect.php";

// Hapus data registrasi sebelumnya dari session (jika ada)
unset($_SESSION['prev_register']);

// Inisialisasi variabel username dan password
$username = '';
$password = '';

// Periksa apakah data registrasi sebelumnya sudah disimpan di session
if(isset($_SESSION['prev_register'])) {
    // Jika ya, ambil nilai username dan password dari session
    $username = $_SESSION['prev_register']['username'];
    $password = $_SESSION['prev_register']['password'];
}

// Jika form registrasi dikirim
if(isset($_POST['register'])) {
    // Tangkap nilai username dan password yang dikirimkan
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan validasi atau proses registrasi sesuai kebutuhan
    
    // Contoh: Simpan data registrasi ke dalam database
    $query = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $query);

    if($result) {
        // Registrasi berhasil, atur session
        $_SESSION['username'] = $username;
        $_SESSION['login'] = true;
        
        // Redirect ke halaman beranda atau halaman lain yang diinginkan setelah registrasi
        header('Location: index.php');
        exit; // Penting untuk menghentikan eksekusi script selanjutnya setelah melakukan redirect
    } else {
        // Registrasi gagal, simpan nilai username dan password ke dalam session untuk digunakan kembali
        $_SESSION['prev_register'] = [
            'username' => '',
            'password' => ''
        ];

        // Redirect kembali ke halaman registrasi
        header('Location: registrasi.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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

        .register-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .register-container h2 {
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
</head>

<body>
</head>
<body>
<div class="container">
    <div class="register-container">
        <h2>Register</h2>
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
                <input type="submit" name="register" value="Register">
            </div>
        </form>
        <?php
        if(isset($error_msg)) {
            echo '<div class="error-msg">'.$error_msg.'</div>';
        }
        ?>
        <div class="form-group">
            <p>Sudah memiliki akun? <a href="login.php">Masuk di sini</a></p>
        </div>
    </div>
</div>

</body>
</html>
