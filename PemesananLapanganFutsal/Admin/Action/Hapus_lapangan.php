<?php
require_once("../../config/koneksi.php");

$id = $_GET['id'];

$query = "DELETE FROM tlapang WHERE Id_lapang='$id'";

$hasil = mysqli_query($koneksi, $query);

 if ($hasil) {
     echo "<script>
        alert('Data lapang berhasil dihapus!');
        window.location.href =
        '../Lapangan_admin.php';
        </script>";
 } else {
       echo"<script>
        alert('Gagal menghapus data lapang!');
        window.location.href =
        '../Lapangan_admin.php';
        </script>";
 }
?>