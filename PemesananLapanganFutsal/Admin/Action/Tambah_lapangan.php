<?php
require_once("../../config/koneksi.php");

/* =========================
   AMBIL DATA
========================= */

$Nama_lapang = $_POST['Nama_lapangan'];
$Harga       = $_POST['Harga'];
$Deskripsi   = $_POST['Deskripsi'];

/* =========================
   UPLOAD GAMBAR
========================= */

$namaFile = $_FILES['Gambar']['name'];

$tmpFile = $_FILES['Gambar']['tmp_name'];

/* pindahkan file */

move_uploaded_file(
    $tmpFile,
    "../../asset/img/" . $namaFile
);

/* =========================
   INSERT DATABASE
========================= */

$query = "INSERT INTO tlapang
(Nama_lapangan, Harga, Deskripsi, Gambar)

VALUES

('$Nama_lapang', '$Harga', '$Deskripsi', '$namaFile')";

$hasil = mysqli_query($koneksi, $query);

/* =========================
   CEK HASIL
========================= */

if ($hasil) {

    echo "<script>
        alert('Lapangan berhasil ditambahkan!');
        window.location.href='../Lapangan_admin.php';
    </script>";

} else {

    echo "<script>
        alert('Gagal menambahkan lapangan!');
        window.history.back();
    </script>";
}
?>