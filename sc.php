<?php
session_start(); // Mulai sesi

// Fungsi untuk menetapkan pesan kesalahan
function setError($message) {
    $_SESSION['error'] = $message;
}

// Fungsi untuk menetapkan pesan sukses
function setSuccess($message) {
    $_SESSION['success'] = $message;
}

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Simpan data pengguna ke sesi atau lakukan validasi dan simpan ke database

        // Contoh menyimpan nama pengguna ke sesi
        $_SESSION['username'] = $_POST['reg_username'];

        // Atur pesan sukses dan arahkan ke halaman login
        setSuccess("Registration successful. Please login.");
        header("Location: login.php");
        exit();
    }
}
?>

?>
<body>
    <header>
        <h1>Hot Wheels Store</h1>
        <nav>
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Produk</a></li>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </nav>
    </header>
    <section class="banner">
        <img src="banner.jpg" alt="Hot Wheels Store Banner">
    </section>
    <section class="produk-unggulan">
        <h2>Produk Unggulan</h2>
        <div class="produk">
            <?php
                // Simulasi data produk
                $produk = array(
                    array("nama" => "Hot Wheels Car 1", "deskripsi" => "Deskripsi produk 1", "gambar" => "produk1.jpg"),
                    array("nama" => "Hot Wheels Car 2", "deskripsi" => "Deskripsi produk 2", "gambar" => "produk2.jpg"),
                    // Tambahkan lebih banyak produk di sini
                );

                // Loop untuk menampilkan produk
                foreach ($produk as $item) {
                    echo "<div class='produk-item'>";
                    echo "<img src='" . $item['gambar'] . "' alt='" . $item['nama'] . "'>";
                    echo "<h3>" . $item['nama'] . "</h3>";
                    echo "<p>" . $item['deskripsi'] . "</p>";
                    echo "<button>Beli Sekarang</button>";
                    echo "</div>";
                }
            ?>
        </div>
    </section>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Hot Wheels Store</p>
    </footer>