    <?php
    session_start();
    require_once("../config/koneksi.php");

    if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'User') {
        header("Location: ../Index.php");
        exit;
    }

    $Username = $_SESSION['Username'];

    $query = "SELECT tbooking.*, tlapang.Nama_lapangan

    FROM tbooking

    JOIN tlapang
    ON tbooking.Id_lapang = tlapang.Id_lapang

    WHERE tbooking.Username = '$Username'

    ORDER BY Id_booking DESC";

    $result = mysqli_query($koneksi, $query);
    ?>

    <!DOCTYPE html>
    <html>

    <head>

        <title>Booking Saya</title>

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

                <a href="Transaksi_user.php">
                    Transaksi
                </a>

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

        <!-- CONTAINER -->

        <div class="booking-container">

            <h1>Booking Saya</h1>

            <div class="booking-grid">

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <div class="booking-card">

                        <div class="booking-top">

                            <h2>

                                <?= $row['Nama_lapangan']; ?>

                            </h2>

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

                        <div class="booking-info">

                            <p>

                                📅
                                <?= $row['Tanggal']; ?>

                            </p>

                            <p>

                                ⏰
                                <?= $row['Jam_mulai']; ?>

                                -

                                <?= $row['Jam_selesai']; ?>

                            </p>

                        </div>

                        <?php if ($row['Status'] == 'menunggu') { ?>

                            <a href="Action/Cancel_booking.php?id=<?= $row['Id_booking']; ?>"
                                onclick="return confirm('Yakin cancel booking?')">

                                <button class="cancel-btn">

                                    Cancel Booking

                                </button>

                            </a>

                        <?php } ?>

                    </div>

                <?php } ?>

            </div>

        </div>

    </body>

    </html>