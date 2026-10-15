<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../Index.php");
    exit;
}

$username = $_SESSION['Username'];

/* =========================
   AMBIL DATA USER
========================= */

$query = mysqli_query(

    $koneksi,

    "SELECT * FROM tuser
     WHERE Username='$username'"
);

$data = mysqli_fetch_assoc($query);

/* =========================
   TOTAL BOOKING
========================= */

$totalBooking = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Username='$username'"
    )
);

/* =========================
   BOOKING TERBARU
========================= */

$recentBooking = mysqli_query(

    $koneksi,

    "SELECT *
     FROM tbooking
     WHERE Username='$username'
     ORDER BY Id_booking DESC
     LIMIT 3"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Profile User</title>

    <link rel="stylesheet" href="../asset/css/style.css">

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

            <a href="Transaksi_user.php">Transaksi</a>

            <a href="Profile.php">
                Profile
            </a>

            <a href="../Logout.php" onclick="return confirm('Yakin ingin logout?')">

                <button class="logout-btn">

                    Logout

                </button>

            </a>

        </div>

    </div>

    <!-- PROFILE -->

    <div class="profile-container">

        <div class="profile-card">

            <!-- AVATAR -->

            <div class="avatar">

                <?= strtoupper(substr($data['Username'], 0, 1)); ?>

            </div>

            <h2>
                <?= $data['Username']; ?>
            </h2>

            <p class="role">

                <?= $data['Role']; ?>

            </p>

            <div class="profile-info">

                <div class="info-box">

                    <h3>Total Booking</h3>

                    <p>
                        <?= $totalBooking['total']; ?>
                    </p>

                </div>

            </div>

                <button type="button" class="edit-profile-btn" onclick="OpenEditProfile()">
                    Edit Profile
                </button>
            </a>

            <!-- RECENT BOOKING -->

            <div class="recent-booking">

                <h3>Booking Terakhir</h3>

                <?php while ($row = mysqli_fetch_assoc($recentBooking)) { ?>

                    <div class="booking-item">

                        <div>

                            <strong>
                                <?= $row['Tanggal']; ?>
                            </strong>

                            <br>

                            <?= $row['Jam_mulai']; ?>

                            -

                            <?= $row['Jam_selesai']; ?>

                        </div>

                        <div>

                            <?php

                            if ($row['Status'] == 'menunggu') {

                                echo "<span class='status status-menunggu'>
                                Menunggu
                                </span>";

                            } elseif ($row['Status'] == 'disetujui') {

                                echo "<span class='status status-disetujui'>
                                Disetujui
                                </span>";

                            } else {

                                echo "<span class='status status-ditolak'>
                                Ditolak
                                </span>";
                            }

                            ?>

                        </div>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <!-- MODAL EDIT PROFILE -->
    <div id="editProfileModal" class="modal">

        <div class="modal-content">

            <span class="close" onclick="closeEditProfile()">
                &times;
            </span>

            <h3>Edit Profile</h3>

            <form action="Action/Proses_edit_profile.php" method="POST">

                <input type="hidden" name="username_lama" value="<?= $_SESSION['Username']; ?>">

                <label>Username</label>
                <input type="text" name="Username" value="<?= $_SESSION['Username']; ?>" required>

                <label>Password Baru (opsional)</label>
                <input type="password" name="Password" placeholder="Isi jika ingin ganti">

                <button type="submit">
                    Simpan
                </button>

            </form>

        </div>

    </div>

</body>

<script src="../asset/js/script.js"></script>

</html>