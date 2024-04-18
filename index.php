<?php
session_start();
require "dbconnect.php";

// Jika session 'login' tidak diatur atau tidak bernilai true, redirect pengguna ke halaman login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit; // Penting untuk menghentikan eksekusi script selanjutnya setelah melakukan redirect
}

if(!isset($_SESSION['login'])){
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: login.php");
    exit; // Penting untuk menghentikan eksekusi script selanjutnya setelah melakukan redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot Wheels Store - Beranda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Hot Wheels Store</h1>
    <nav>
        <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="#produk">Produk</a></li>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="kontak.php">Kontak</a></li>
        </ul>
    </nav>
    <?php
    // Periksa apakah session username telah di-set
    if (isset($_SESSION['username'])) {
        $nama_pengguna = $_SESSION['username'];
        echo "<p>Selamat datang, $nama_pengguna!</p>";
    }
    ?>
    </header>
    <section class="banner" style="background-image: url('bg 1.jpg');">
    </section>
    <section id="produk" class="produk-heading">
        <h2>Produk</h2>
    </section>
    <div class="produk">
        <?php
        // Koneksi ke database
        $con = mysqli_connect("localhost", "root", "", "minpro");

        // Periksa koneksi
        if (mysqli_connect_errno()) {
            echo "Koneksi database gagal: " . mysqli_connect_error();
        }

        // Query untuk mengambil semua data produk dari database
        $sql = "SELECT * FROM barang";
        $result = mysqli_query($con, $sql);

        // Periksa apakah ada data produk yang ditemukan
        if (mysqli_num_rows($result) > 0) {
            // Loop untuk menampilkan semua produk
            while ($row = mysqli_fetch_assoc($result)) {
                // Tampilkan informasi produk
                echo "<div class='produk-item'>";
                echo "<h3>" . $row['nama'] . "</h3>";
                echo "<p>" . $row['harga'] . "</p>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row['foto']) . "' />";
                echo "</div>";
            }
        } else {
            // Jika tidak ada produk yang ditemukan, tampilkan pesan
            echo "Tidak ada produk yang ditemukan.";
        }

        // Tutup koneksi database
        mysqli_close($con);
        ?>
         </div>
    </section>
    <style>
      
      body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-image: url("bg\ 1.jpg"); 
    background-size: cover; 
    background-repeat: no-repeat; 
    background-attachment: fixed; 
}

.banner {
    text-align: center;
    padding: 100px 0; /* Sesuaikan padding atas dan bawah sesuai kebutuhan */
    background-image: url('bg 1.jpg'); /* Hapus background-image dari inline style jika sudah tidak digunakan */
    background-size: cover;
    background-position: center;
    height: 600px; /* Sesuaikan tinggi sesuai kebutuhan */
}

.banner img {
    display: none; /* Sembunyikan gambar jika tidak digunakan */
}



        header {
    background-color:orange;
    color: #fff;
    padding: 20px;
    text-align: center;
    position: sticky; /* Membuat header menjadi sticky */
    top: 0; /* Meletakkan header di bagian atas */
    z-index: 1000; /* Menetapkan z-index untuk memastikan header muncul di atas konten */
}
header h1 {
    margin: 0 auto; /* Meletakkan header1 di tengah */
    font-size: 28px;
}

nav ul {
    margin-top: 20px; /* Memberikan jarak dari header1 */
    padding: 0;
    list-style-type: none;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}



        .produk-heading {
            background-color: orange;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .produk-heading h2 {
            margin: 0;
            font-size: 24px;
        }

.produk {
    padding: 20px;
    text-align: center;
}

.produk h2 {
    margin-bottom: 20px;
}

.kategori {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}

.kategori-item {
    margin: 10px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
}

.kategori-item img {
    width: 100px;
    height: auto;
    margin-bottom: 10px;
}

.kategori-item h3 {
    margin: 0;
    font-size: 18px;
}

.kategori-item p {
    margin: 10px 0;
}
.produk {
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between; /* Menyebarkan item secara merata di dalam flex container */
    }

    .produk-item {
        flex-basis: calc(25% - 20px); /* Lebar relatif, dikurangi dengan jarak yang diinginkan */
        margin-bottom: 20px; /* Jarak antara item */
        box-sizing: border-box; /* Padding tidak mempengaruhi lebar item */
        padding: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        border-radius: 5px;
    }

    .produk-item img {
        width: 100%;
        height: auto;
    }
/* Optional: Menambahkan sedikit ruang antar item */
.produk-item {
    margin-right: 10px;
    margin-bottom: 10px;
}

/* Menghapus margin kanan item terakhir di setiap baris */
.produk-item:nth-child(4n) {
    margin-right: 0;
}

/* Responsive: Setiap item menjadi 50% lebar ketika layar lebih kecil dari 768px */
@media (max-width: 768px) {
    .produk-item {
        flex: 0 0 50%;
    }
}


footer {
    background-color: orange;
    color: #fff;
    padding: 10px;
    text-align: center;
}

    </style>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Hot Wheels Store</p>
    </footer>
</body>
</html>

