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
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
<body>
    <style>
        /* Styles untuk tampilan halaman admin */
body {
    font-family: 'Roboto Slab', serif;
}

.container {
    margin-top: 50px;
}

h2 {
    font-family: 'Montserrat', sans-serif;
}

.form-group {
    margin-bottom: 20px;
}

input[type="text"],
input[type="file"] {
    width: 100%;
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
</body>
</html>