<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Panel</title>

    <link rel="stylesheet" href="../asset/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <div class="wrapper">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <h2>Admin Panel</h2>

            <a href="Dashboard_admin.php">Dashboard</a>

            <a href="Lapangan_admin.php">Lapangan</a>

            <a href="Booking_admin.php">Booking</a>

            <a href="Pembayaran_admin.php">Pembayaran</a>

            <a href="../logout.php" onclick="return confirm('Yakin logout?')">
                Logout
            </a>

        </div>

        <!-- CONTENT -->
        <div class="main-content">