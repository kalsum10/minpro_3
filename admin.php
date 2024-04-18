<?php
// Proses Formulir hanya jika data telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconnect.php';

    // Buat objek database
    $db = new Database();

    // Jika permintaan adalah untuk menambahkan data baru
    if (isset($_POST['submit'])) {
        // Tangani data yang diterima dari formulir
        $nama_produk = $_POST['nama_produk'];
        $harga = $_POST['harga'];

        // Tangani gambar yang diunggah
        $foto = $_FILES['gambar']['tmp_name'];
        $foto_name = $_FILES['gambar']['name'];
        $foto_size = $_FILES['gambar']['size'];

        // Baca file gambar jika ada
        if ($foto_name != "") {
            $gambar_data = file_get_contents($foto);
        } else {
            $gambar_data = null; // Atur null jika tidak ada gambar yang diunggah
        }

        // Panggil metode tambahData untuk menambahkan data ke database
        if ($db->tambahData($nama_produk, $harga, $gambar_data)) {
            $success_message = "Data berhasil ditambahkan.";
        } else {
            $error_message = "Gagal menambahkan data.";
        }
    }

    // Jika permintaan adalah untuk menghapus data
    if (isset($_POST['hapus'])) {
        // Tangani ID data yang akan dihapus
        $id_to_delete = $_POST['id_to_delete'];

        // Panggil metode hapusData untuk menghapus data dari database berdasarkan ID
        if ($db->hapusDataByID($id_to_delete)) {
            $success_message = "Data dengan ID $id_to_delete berhasil dihapus.";
        } else {
            $error_message = "Gagal menghapus data.";
        }
    }
}

// Proses logout jika tombol logout ditekan
if (isset($_POST['logout'])) {
    // Hapus semua session
    session_unset();
    session_destroy();

    // Redirect ke halaman beranda setelah logout
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css"> <!-- Sesuaikan dengan path dan nama file CSS Anda -->
</head>
<body>
    <header>
        <h1>Admin Area</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <button type="submit" name="logout">Logout</button> <!-- Tambahkan tombol logout -->
        </form>
    </header>
    <!-- Tambahkan seluruh konten admin di sini -->

    <!-- Optional: Tambahkan pesan sukses atau gagal di sini -->

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Hot Wheels Store</p>
    </footer>
</body>
</html>

<body>
    <style>
      /* Styles untuk tampilan halaman admin */
      body {
    font-family: 'Roboto Slab', serif;
    background-image: url("bg 1.jpg"); /* Ganti 'path_ke_gambar_background.jpg' dengan URL atau path gambar latar belakang yang Anda inginkan */
    background-size: cover; /* Menyesuaikan ukuran gambar agar mencakup seluruh latar belakang */
    background-repeat: no-repeat; /* Mencegah gambar latar belakang diulang */
    background-attachment: fixed; /* Membuat gambar latar belakang tetap saat menggulir */
}

.container {
    margin-top: 50px;
    background-color: rgba(255, 255, 255, 0.9); /* Tambahkan warna latar belakang kontainer dengan kejelasan 90% */
    padding: 20px; /* Tambahkan padding untuk kontainer */
    border-radius: 10px; /* Membuat sudut border kontainer melengkung */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Memberikan efek bayangan pada kontainer */
}

/* Seluruh CSS lainnya tetap seperti sebelumnya */

h2 {
    font-family: 'Montserrat', sans-serif;
    margin-bottom: 30px; /* Beri jarak antara judul dan form */
}

.form-group {
    margin-bottom: 20px;
}

input[type="text"],
input[type="file"] {
    width: calc(100% - 22px); /* Sesuaikan lebar input dengan margin */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

button[type="submit"]:focus {
    outline: none;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

/* Grid untuk menampilkan foto-foto */
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px; /* Mengatasi margin kanan yang dihasilkan oleh Bootstrap */
    margin-left: -15px; /* Mengatasi margin kiri yang dihasilkan oleh Bootstrap */
}

.col-lg-4 {
    flex: 0 0 calc(33.333333% - 30px); /* Mengatur lebar kolom agar tiga bersejajar dengan jarak */
    max-width: calc(33.333333% - 30px); /* Mengatur lebar maksimum agar tidak melebihi 33.33% */
    margin: 15px; /* Beri jarak antar kolom */
}

/* Style untuk caption di bawah foto */
.portfolio-caption {
    text-align: center;
}

.portfolio-caption-heading {
    font-size: 18px;
    margin-top: 15px;
    margin-bottom: 10px;
}

.portfolio-caption-subheading {
    font-size: 16px;
    color: #6c757d;
    margin-bottom: 15px;
}

    </style>

    <h2>Tambah Produk</h2>
    <?php if(isset($success_message)): ?>
        <script>
            alert("<?php echo $success_message; ?>");
        </script>
    <?php endif; ?>
    <?php if(isset($error_message)): ?>
        <script>
            alert("<?php echo $error_message; ?>");
        </script>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="nama_produk" placeholder="Nama Produk" required><br>
        <input type="text" name="harga" placeholder="Harga" required><br>
        <input type="file" name="gambar" accept="image/*"><br> <!-- Hapus required jika tidak wajib -->
        <button type="submit" name="submit">Tambahkan</button> <!-- Tambahkan name="submit" -->
    </form>

    <h2>Hapus Produk</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="id_to_delete" placeholder="Masukkan ID Produk yang Ingin Dihapus" required><br>
        <button type="submit" name="hapus">Hapus Produk</button> <!-- Tambahkan name="hapus" -->
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="text-center">
            <h3 class="section-subheading text-muted">Semua Produk</h3>
        </div>
        <div class="row">
            <?php
            // Koneksi ke database
            $con = mysqli_connect("localhost", "root", "", "minpro");

            // Periksa koneksi
            if (mysqli_connect_errno()) {
                echo "Koneksi database gagal: " . mysqli_connect_error();
            }

            // Query untuk mengambil semua data gambar dari database
            $sql = "SELECT * FROM barang";
            $result = mysqli_query($con, $sql);

            // Periksa apakah ada data gambar yang ditemukan
            if (mysqli_num_rows($result) > 0) {
                // Loop untuk menampilkan semua gambar
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_to_show = $row['id'];
                    $nama_karakter = $row['nama'];
                    $asal = $row['harga'];
                    $foto = $row['foto'];
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- Portfolio item -->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $id_to_show; ?>">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <!-- Ganti sumber gambar dengan gambar dari database -->
                                <img class="img-fluid" src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="..." />
                            </a>
                           <div class="portfolio-caption">
                           <div class="portfolio-caption-heading"><?php echo $nama_karakter; ?></div>
                           <div class="portfolio-caption-subheading text-muted"><?php echo $asal; ?></div>
                          </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                // Jika tidak ada gambar yang ditemukan, tampilkan pesan
                echo "Tidak ada gambar yang ditemukan.";
            }

            // Tutup koneksi database
            mysqli_close($con);
            ?>
        </div>
    </div>
</section>
