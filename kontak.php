<?php
// Proses logout jika tombol logout ditekan
if (isset($_POST['logout'])) {
    // Hapus semua session
    session_unset();
    session_destroy();

    // Redirect ke halaman beranda setelah logout
    header("Location: index.php");
    exit;
}

// Proses pengiriman pesan jika formulir dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data formulir telah dikirimkan
    if (isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['pesan'])) {
        // Tangkap data dari formulir
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $pesan = $_POST['pesan'];
        
        // Konfigurasi pengiriman email
        $to = "putrikalsumburhani@gmail.com";
        $subject = "Pesan dari " . $nama;
        $message = "Nama: " . $nama . "\nEmail: " . $email . "\nPesan: " . $pesan;
        $headers = "From: " . $email;

        // Kirim email
        if (mail($to, $subject, $message, $headers)) {
            echo "Email berhasil dikirim.";
        } else {
            echo ""; // Jangan menampilkan pesan apapun jika gagal
        }
    } else {
        echo ""; // Jangan menampilkan pesan apapun jika ada masalah dengan data formulir
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("bg\ 1.jpg"); /* Ganti 'gambar-background-kontak.jpg' dengan nama gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
        }

        .container {
            max-width: 400px; /* Lebar maksimum kotak kontak */
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.8); /* Tambahkan transparansi untuk kotak kontak */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <button type="submit" name="logout" style="float: right;">Logout</button> <!-- Tombol Logout -->
        </form>
        <h2>Form Kontak</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama"><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br>
            
            <label for="pesan">Pesan:</label><br>
            <textarea id="pesan" name="pesan" rows="4"></textarea><br><br>
            
            <input type="submit" value="Kirim">
        </form>
    </div>
</body>
</html>
