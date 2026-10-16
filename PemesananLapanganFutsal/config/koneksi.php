<?php
$host     = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASS') ?: "";
$database = getenv('DB_NAME') ?: "db_pemesananlapanganfutsal";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Gagal terhubung ke database". mysqli_connect_error());
}
