<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'Admin') {
    header("Location: ../Index.php");
    exit;
}

include "Layout_admin.php";

/* =========================
   TOTAL USER
========================= */

$user = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tuser
         WHERE Role='User'"
    )
);

/* =========================
   TOTAL BOOKING
========================= */

$booking = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking"
    )
);

/* =========================
   TOTAL LAPANGAN
========================= */

$lapangan = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tlapang"
    )
);

/* =========================
   BOOKING HARI INI
========================= */

$today = date("Y-m-d");

$bookingHariIni = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Tanggal='$today'"
    )
);

/* =========================
   BOOKING MENUNGGU
========================= */

$menunggu = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Status='menunggu'"
    )
);

/* =========================
   BOOKING DISETUJUI
========================= */

$disetujui = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Status='disetujui'"
    )
);

/* =========================
   BOOKING DITOLAK
========================= */

$ditolak = mysqli_fetch_assoc(

    mysqli_query(

        $koneksi,

        "SELECT COUNT(*) as total
         FROM tbooking
         WHERE Status='ditolak'"
    )
);

/* =========================
   RECENT BOOKING
========================= */

$recent = mysqli_query(

    $koneksi,

    "SELECT tbooking.*,
    tlapang.Nama_lapangan

    FROM tbooking

    INNER JOIN tlapang
    ON tbooking.Id_lapang =
    tlapang.Id_lapang

    ORDER BY Id_booking DESC

    LIMIT 5"
);
?>

<h1>Dashboard Admin</h1>

<!-- CARD -->

<div class="dashboard-card">

    <div class="card">

        <h3>Total User</h3>

        <p>
            <?= $user['total']; ?>
        </p>

    </div>

    <div class="card">

        <h3>Total Booking</h3>

        <p>
            <?= $booking['total']; ?>
        </p>

    </div>

    <div class="card">

        <h3>Total Lapangan</h3>

        <p>
            <?= $lapangan['total']; ?>
        </p>

    </div>

    <div class="card">

        <h3>Booking Hari Ini</h3>

        <p>
            <?= $bookingHariIni['total']; ?>
        </p>

    </div>

    <div class="card">

        <h3>Menunggu</h3>

        <p>

            <?= $menunggu['total']; ?>

        </p>

    </div>

    <div class="card">

        <h3>Disetujui</h3>

        <p>

            <?= $disetujui['total']; ?>

        </p>

    </div>

    <div class="card">

        <h3>Ditolak</h3>

        <p>

            <?= $ditolak['total']; ?>

        </p>

    </div>

</div>

<br><br>

<!-- RECENT BOOKING -->

<h2>Booking Terbaru</h2>

<div class="table-container">

    <table>

    <tr>

        <th>User</th>

        <th>Lapangan</th>

        <th>Tanggal</th>

        <th>Status</th>

    </tr>

    <?php while ($row = mysqli_fetch_assoc($recent)) { ?>

        <tr>

            <td>
                <?= $row['Username']; ?>
            </td>

            <td>
                <?= $row['Nama_lapangan']; ?>
            </td>

            <td>
                <?= $row['Tanggal']; ?>
            </td>

            <td>

                <?php

                $status = strtolower(trim($row['Status']));

                if ($status == 'menunggu') {

                    echo "<span class='status status-menunggu'>
                    Menunggu
                    </span>";

                } elseif ($status == 'disetujui') {

                    echo "<span class='status status-disetujui'>
                    Disetujui
                    </span>";

                } elseif ($status == 'dibayar') {

                    echo "<span class='status status-disetujui'>
                    Dibayar
                    </span>";

                } else {

                    echo "<span class='status status-ditolak'>
                    Ditolak
                    </span>";
                }

                ?>

            </td>

        </tr>

    <?php } ?>

</table>

</div>

<?php include "Footer_admin.php"; ?>