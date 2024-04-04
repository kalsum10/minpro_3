<?php
class Database {
    private $con;

    // Konstruktor untuk membuat koneksi ke database
    public function __construct() {
        $this->con = mysqli_connect("localhost", "root", "", "minpro");

        // Periksa koneksi
        if (mysqli_connect_errno()) {
            echo "Koneksi database gagal: " . mysqli_connect_error();
            exit();
        }
    }

   // Fungsi untuk menambahkan data ke database
public function tambahData($nama_produk, $harga, $gambar_data) {
    // Periksa apakah id sudah ada di dalam tabel
    $id = 1; // Id awal yang akan dicoba
    while ($this->idExists($id)) {
        $id++; // Coba id berikutnya jika sudah ada
    }

    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO barang (id, nama, harga, foto) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->con, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $id, $nama_produk, $harga, $gambar_data);
    mysqli_stmt_execute($stmt);

    // Periksa apakah data berhasil ditambahkan
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return true;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

// Fungsi untuk memeriksa apakah id sudah ada di dalam tabel
private function idExists($id) {
    $stmt = mysqli_prepare($this->con, "SELECT id FROM barang WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $num_rows > 0;
}


    // Fungsi untuk mendapatkan semua data gambar dari database
    public function getAllData() {
        $result = mysqli_query($this->con, "SELECT * FROM barang");
        $data = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    // Fungsi untuk mendapatkan data gambar berdasarkan ID
    public function getDataByID($id) {
        $stmt = mysqli_prepare($this->con, "SELECT * FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        return $data;
    }

    public function checkIDExist() {
        $check_query = "SELECT id FROM barang WHERE id = LAST_INSERT_ID()";
        $check_result = mysqli_query($this->con, $check_query);
        return $check_result;
    }

    public function hapusDataByID($id) {
        // Lakukan kueri penghapusan data dengan menggunakan ID yang diberikan
        $sql = "DELETE FROM barang WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        
        // Jalankan kueri
        if ($stmt->execute()) {
            return true; // Penghapusan berhasil
        } else {
            return false; // Gagal menghapus data
        }
    }
}
?>