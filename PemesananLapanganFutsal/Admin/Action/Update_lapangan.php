<?php
require_once("../../config/koneksi.php");

$id = $_POST['Id_lapang'];
$nama = $_POST['Nama_lapangan'];
$harga = $_POST['Harga'];
$deskripsi = $_POST['Deskripsi'];

$query = "UPDATE tlapang SET 
    Nama_lapangan='$nama',
    Harga='$harga',
    Deskripsi='$deskripsi'
    WHERE Id_lapang='$id'";

$hasil = mysqli_query($koneksi, $query);

 if ($hasil) {
     echo "<script>
        alert('Data lapang berhasil ditambahkan!');
        window.location.href =
        '../Lapangan_admin.php';
        </script>";
 } else {
       echo"<script>
        alert('Gagal menambahkan data lapang!');
        window.location.href =
        '../Lapangan_admin.php';
        </script>";
 }
?>