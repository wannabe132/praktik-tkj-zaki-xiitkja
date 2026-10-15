<?php
session_start();
require_once("../config/koneksi.php");

if (
    !isset($_SESSION['Role']) ||
    $_SESSION['Role'] != 'User'
) {
    header("Location: ../Index.php");
    exit;
}

$where = "";

if (
    isset($_GET['lapangan'])
    &&
    $_GET['lapangan'] != ""
) {

    $id_lapang = $_GET['lapangan'];

    $where =
        "AND tbooking.Id_lapang='$id_lapang'";
}

/* =========================
   AMBIL DATA BOOKING
========================= */

$query = "SELECT
tbooking.Tanggal,
tbooking.Jam_mulai,
tbooking.Jam_selesai,
tbooking.Status,
tlapang.Nama_lapangan,
tbooking.Username

FROM tbooking
INNER JOIN tlapang
ON tbooking.Id_lapang = tlapang.Id_lapang
WHERE tbooking.Status != 'ditolak'
$where
ORDER BY tbooking.Tanggal ASC,
tbooking.Jam_mulai ASC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Jadwal Lapangan</title>

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

    <!-- CONTENT -->

    <div class="transaksi-container">

        <h1>Jadwal Lapangan</h1>

        <form method="GET" class="filter-form">

            <select name="lapangan">

                <option value="">
                    Semua Lapangan
                </option>

                <?php

                $lapangan = mysqli_query(
                    $koneksi,
                    "SELECT * FROM tlapang"
                );

                while ($l = mysqli_fetch_assoc($lapangan)) {

                    ?>

                    <option value="<?= $l['Id_lapang']; ?>" <?php

                      if (
                          isset($_GET['lapangan'])
                          &&
                          $_GET['lapangan']
                          == $l['Id_lapang']
                      ) {
                          echo "selected";
                      }

                      ?>>

                        <?= $l['Nama_lapangan']; ?>

                    </option>

                <?php } ?>

            </select>

            <button type="submit" class="filter-btn">
                Cari
            </button>

            <a href="Jadwal.php" class="reset-btn">Reset</a>

        </form>

        <table class="table-modern">

            <thead>

                <tr>

                    <th>Lapangan</th>

                    <th>Username</th>

                    <th>Tanggal</th>

                    <th>Jam</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                <?php while (
                    $row =
                    mysqli_fetch_assoc($result)
                ) { ?>

                    <tr>

                        <td>

                            <?= $row['Nama_lapangan']; ?>

                        </td>

                        <td>

                            <?= $row['Username']; ?>

                        </td>


                        <td>

                            <?= $row['Tanggal']; ?>

                        </td>

                        <td>

                            <?= $row['Jam_mulai']; ?>

                            -

                            <?= $row['Jam_selesai']; ?>

                        </td>

                        <td>

                            <?php

                            if (
                                $row['Status'] == 'disetujui'
                                || $row['Status'] == 'dibayar'
                            ) {

                                echo "
                                    <span class='badge green'>
                                    Sudah di booking
                                    </span>";

                            } else {

                                echo "
                                    <span class='badge orange'>
                                    Menunggu
                                    </span>";
                            }

                            ?>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</body>

</html>