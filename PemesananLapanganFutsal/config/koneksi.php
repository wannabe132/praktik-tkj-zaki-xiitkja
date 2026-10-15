<?php 

$host     = "localhost";
$username = "root";
$password = "";
$database = "db_pemesananlapanganfutsal";

$koneksi = new mysqli($host, $username, $password, $database);
if (!$koneksi) {
        die("Gagal terhubung ke database". mysqli_connect_error());
    }


?>