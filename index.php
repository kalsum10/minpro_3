<?php
session_start();
require "dbconnect.php";

if(!isset($_SESSION['login'])){
    $notlogin = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
    <header>
        <h1>Hot Wheels Store</h1>
        <nav>
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Produk</a></li>
                <li><a href="#">Kategori</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </nav>
    </header>
    <section class="banner">
        <img src="banner.jpg" alt="Hot Wheels Store Banner">
    </section>
    <section class="produk">
        <h2>Produk </h2>
        <div class="produk">
        <section class="Kategori">
            <h2>Kategori</h2>
                <div class="kategori">
                    <h3>Category Populer</h3>
                    <div class="kategori-Populer">
                        <img src="hot wheels 2.jpg" alt="Category 1" onclick="bukaModal('hot wheels 2.jpg')">>
                        <img src="hot wheels 5.jpg" alt="Category 2" onclick="bukaModal('hot wheels 5.jpg')">>
                        <img src="hot wheels 8.jpg" alt="Category 3" onclick="bukaModal('hot wheels 8.jpg')">>
                        <img src="hot wheels 12.jpg" alt="Category 4" onclick="bukaModal('hot wheels 12.jpg')">>
                    </div>
                </div>
                <div class="kategori">
                    <h3>Category Terlaris</h3>
                    <div class="kategori-Terlaris">
                        <img src="hot wheels 1.jpg" alt="Category 5" onclick="bukaModal('hot wheels 1.jpg')">>
                        <img src="hot wheels 4.jpg" alt="Category 6" onclick="bukaModal('hot wheels 4.jpg')">>
                        <img src="hot wheels 7.jpg" alt="Category 7" onclick="bukaModal('hot wheels 7.jpg')">>
                        <img src="hot wheels 10.jpg" alt="Category 8" onclick="bukaModal('hot wheels 10.jpg')">>
                    </div>
                </div>
                <div class="kategori">
                    <h3>Category Terbaru</h3>
                    <div class="kategori-Terbaru">
                        <img src="hot wheels 3.jpg" alt="Category 9" onclick="bukaModal('hot wheels 3.jpg')">>
                        <img src="hot wheels 6.jpg" alt="Category 10" onclick="bukaModal('hot wheels 6.jpg')">>
                        <img src="hot wheels 9.jpg" alt="Category 11" onclick="bukaModal('hot wheels 9.jpg')">>
                        <img src="hot wheels 11.jpg" alt="Category 12" onclick="bukaModal('hot wheels 11.jpg')">>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Hot Wheels Store</p>
    </footer>
</body>
</html>