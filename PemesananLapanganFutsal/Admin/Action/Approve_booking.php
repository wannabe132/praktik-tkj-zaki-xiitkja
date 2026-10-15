<?php
require_once("../../config/koneksi.php");

$id = $_GET['id'];

$query = "UPDATE tbooking
SET Status='disetujui'
WHERE Id_booking='$id'";

mysqli_query($koneksi, $query);

header("Location: ../Booking_admin.php");
?>