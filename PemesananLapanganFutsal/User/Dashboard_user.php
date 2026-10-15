<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../Index.php");
    exit;
}

/* =========================
   TOTAL BOOKING
========================= */

$username = $_SESSION['Username'];

$totalBooking = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Username='$username'"
    )
);

/* =========================
   BOOKING DISETUJUI
========================= */

$totalDisetujui = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Username='$username'
         AND Status='disetujui'"
    )
);

/* =========================
   BOOKING MENUNGGU
========================= */

$totalMenunggu = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Username='$username'
         AND Status='menunggu'"
    )
);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard User</title>

    <link rel="stylesheet"
          href="../asset/css/style.css">

</head>

<body>

<!-- NAVBAR -->

<div class="navbar-user">

    <h2>AYO</h2>

    <div class="navbar-menu">

        <a href="Dashboard_user.php">
            Home
        </a>

        <a href="Lapangan_user.php">
            Lapangan
        </a>

        <a href="Jadwal.php">
            Jadwal
        </a>

        <a href="Booking_user.php">
            Booking Saya
        </a>

        <a href="Transaksi_user.php">
            Transaksi
        </a>

        <a href="Profile.php">
            Profile
        </a>

        <a href="../Logout.php"
           onclick="return confirm('Yakin ingin logout?')">

            <button class="logout-btn">

                Logout

            </button>

        </a>

    </div>

</div>

<!-- HERO -->

<div class="hero">

    <div class="overlay">

        <h1>

            Selamat Datang,
            <?= $_SESSION['Username']; ?>

        </h1>

        <p>

            Booking lapangan jadi lebih mudah

        </p>

    </div>

</div>

<!-- DASHBOARD CARD -->

<div class="dashboard-user">

    <div class="dash-card">

        <h3>Total Booking</h3>

        <p>

            <?= $totalBooking['total']; ?>

        </p>

    </div>

    <div class="dash-card">

        <h3>Disetujui</h3>

        <p>

            <?= $totalDisetujui['total']; ?>

        </p>

    </div>

    <div class="dash-card">

        <h3>Menunggu</h3>

        <p>

            <?= $totalMenunggu['total']; ?>

        </p>

    </div>

</div>

<!-- QUICK MENU -->

<div class="quick-menu">

    <a href="Lapangan_user.php"
       class="menu-card">

        ⚽

        <span>

            Booking Lapangan

        </span>

    </a>

    <a href="Booking_user.php"
       class="menu-card">

        📋

        <span>

            Booking Saya

        </span>

    </a>

    <a href="Profile.php"
       class="menu-card">

        👤

        <span>

            Profile

        </span>

    </a>

</div>

<script src="../asset/js/script.js"></script>

</body>

</html>