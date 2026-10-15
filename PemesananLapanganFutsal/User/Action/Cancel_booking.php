<?php
session_start();
require_once("../../config/koneksi.php");

$id = $_GET['id'];

// pastikan hanya cancel yang masih menunggu
$query = "DELETE FROM tbooking 
          WHERE Id_booking = '$id' 
          AND Status = 'menunggu'";

mysqli_query($koneksi, $query);

header("Location: ../Booking_user.php");
?>