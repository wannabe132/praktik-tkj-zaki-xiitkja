<?php
session_start();
require_once("../config/koneksi.php");

if (
    !isset($_SESSION['Role'])
    || $_SESSION['Role'] != 'Admin'
) {

    header("Location: ../Index.php");
    exit;
}

$query = "SELECT

ttransaksi.*,

tbooking.Username,
tbooking.Tanggal,
tbooking.Jam_mulai,
tbooking.Jam_selesai,

tlapang.Nama_lapangan

FROM ttransaksi

INNER JOIN tbooking
ON ttransaksi.Id_booking =
tbooking.Id_booking

INNER JOIN tlapang
ON tbooking.Id_lapang =
tlapang.Id_lapang

ORDER BY Id_transaksi DESC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Pembayaran Admin</title>

    <link rel="stylesheet" href="../asset/css/admin.css">

</head>

<body>

    <?php include "Layout_admin.php"; ?>

    <h1>Konfirmasi Pembayaran</h1>

    <div class="table-container">

        <table class="table-lapangan">

            <tr>

                <th>User</th>

                <th>Lapangan</th>

                <th>Tanggal</th>

                <th>Jam</th>

                <th>Metode</th>

                <th>Nominal</th>

                <th>Bukti</th>

                <th>Status</th>

                <th>Aksi</th>

            </tr>

            <?php while (
                $row = mysqli_fetch_assoc($result)
            ) { ?>

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

                        <?= $row['Jam_mulai']; ?>

                        -

                        <?= $row['Jam_selesai']; ?>

                    </td>

                    <td>

                        <?= $row['Metode_pembayaran']; ?>

                    </td>

                    <td>

                        Rp<?= number_format($row['Nominal']); ?>

                    </td>

                    <td>

                    <a href="../asset/bukti/"<?= $row['Bukti_pembayaran']; ?>target="_blank">
                        <img src="../asset/bukti/<?=$row['Bukti_pembayaran']; ?>" width="100" height="100" style="object-fit: cover; border-radius:10px;">
                    </a>
                    </td>

                    <td>

                        <?php

                        if (
                            $row['Status_pembayaran']
                            == 'menunggu'
                        ) {

                            echo "<span class='status status-menunggu'>
            Menunggu
            </span>";

                        } elseif (
                            $row['Status_pembayaran']
                            == 'lunas'
                        ) {

                            echo "<span class='status status-disetujui'>
            Lunas
            </span>";

                        } else {

                            echo "<span class='status status-ditolak'>
            Ditolak
            </span>";
                        }

                        ?>

                    </td>

                    <td>

                        <?php

                        if (
                            $row['Status_pembayaran']
                            == 'menunggu'
                        ) {

                            ?>

                            <a href="Action/Approve_pembayaran.php?id=
    <?= $row['Id_transaksi']; ?>">

                                Approve

                            </a>

                            |

                            <a href="Action/Disapprove_pembayaran.php?id=
    <?= $row['Id_transaksi']; ?>">

                                Tolak

                            </a>

                        <?php } else { ?>

                            -

                        <?php } ?>

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>

    <?php include "Footer_admin.php"; ?>

</body>

</html>