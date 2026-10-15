<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../Index.php");
    exit;
}

$username = $_SESSION['Username'];

$query = "SELECT 
tbooking.Id_booking,
tbooking.Tanggal,
tbooking.Status,
tbooking.Jam_mulai,
tbooking.Jam_selesai,
tlapang.Nama_lapangan,
tlapang.Harga,
ttransaksi.Status_pembayaran

FROM tbooking

INNER JOIN tlapang 
ON tbooking.Id_lapang = tlapang.Id_lapang

LEFT JOIN ttransaksi 
ON tbooking.Id_booking = ttransaksi.Id_booking

WHERE tbooking.Username='$username'

ORDER BY tbooking.Id_booking DESC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Transaksi Saya</title>

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

        <h1>Transaksi Saya</h1>

        <table class="table-modern">

            <thead>

                <tr>

                    <th>Lapangan</th>

                    <th>Tanggal</th>

                    <th>Jam</th>

                    <th>Status Booking</th>

                    <th>Status Pembayaran</th>

                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <?php

                    $jamMulai = strtotime($row['Jam_mulai']);

                    $jamSelesai = strtotime($row['Jam_selesai']);

                    $durasi = ($jamSelesai - $jamMulai) / 3600;

                    $totalBayar = $durasi * $row['Harga'];

                    ?>

                    <tr>

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

                        <!-- STATUS BOOKING -->

                        <td>

                            <?php

                            if ($row['Status'] == 'disetujui') {

                                echo "<span class='badge green'>
                    Disetujui
                    </span>";

                            } elseif ($row['Status'] == 'ditolak') {

                                echo "<span class='badge red'>
                    Ditolak
                    </span>";

                            } else {

                                echo "<span class='badge orange'>
                    Menunggu
                    </span>";
                            }

                            ?>

                        </td>

                        <!-- STATUS PEMBAYARAN -->

                        <td>

                            <?php

                            if ($row['Status_pembayaran'] == 'menunggu') {

                                echo "<span class='badge orange'>
                    Menunggu Verifikasi
                    </span>";

                            } elseif ($row['Status_pembayaran'] == 'lunas') {

                                echo "<span class='badge green'>
                    Lunas
                    </span>";

                            } else {

                                echo "<span class='badge red'>
                    Belum Bayar
                    </span>";
                            }

                            ?>

                        </td>

                        <!-- AKSI -->

                        <td>

                            <!-- BUTTON BAYAR -->

                            <?php

                            if (
                                $row['Status'] == 'disetujui'
                                &&
                                empty($row['Status_pembayaran'])
                            ) {

                                ?>

                                <button type="button" onclick="openBayar(

            '<?= $row['Id_booking']; ?>',

            '<?= $row['Nama_lapangan']; ?>',

            '<?= $row['Tanggal']; ?>',

            '<?= $row['Jam_mulai']; ?>',

            '<?= $row['Jam_selesai']; ?>',

            '<?= $totalBayar; ?>'

            )">

                                    Bayar

                                </button>

                            <?php } ?>

                            <!-- INVOICE -->

                            <?php

                            if (
                                $row['Status_pembayaran'] == 'lunas'
                            ) {

                                ?>

                                <a href="Invoice.php?id=
            <?= $row['Id_booking']; ?>">

                                    Invoice

                                </a>

                            <?php } ?>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

    <!-- MODAL BAYAR -->

    <div id="bayarModal" class="modal">

        <div class="modal-content">

            <span class="close" onclick="closeBayar()">

                &times;

            </span>

            <h3>Pembayaran</h3>

            <form action="Action/Proses_pembayaran.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="Id_booking" id="idBooking">

                <label>Lapangan</label>

                <input type="text" id="namaLapangan" readonly>

                <label>Tanggal</label>

                <input type="text" id="tanggal" readonly>

                <label>Jam</label>

                <input type="text" id="jam" readonly>

                <label>Total Bayar</label>

                <input type="text" id="totalBayar" readonly>

                <input type="hidden" name="Total_bayar" id="totalBayarHidden">

                <!-- REKENING -->

                <div class="rekening-box">

                    <h4>Transfer Pembayaran</h4>

                    <p>
                        Bank BCA :
                        1234567890
                    </p>

                    <p>
                        DANA :
                        08123456789
                    </p>

                    <p>
                        a/n AYO FUTSAL
                    </p>

                </div>

                <!-- METODE -->

                <label>Metode Pembayaran</label>

                <select name="Metode_pembayaran">

                    <option value="Transfer Bank">

                        Transfer Bank

                    </option>

                    <option value="E-Wallet">

                        E-Wallet

                    </option>

                </select>

                <!-- NOMINAL -->

                <label>Nominal</label>

                <input type="number" name="Nominal" required>

                <label>Bukti Pembayaran</label>
                <input type="file" name="Bukti_pembayaran" required>

                <button type="submit">

                    Bayar

                </button>

            </form>

        </div>

    </div>

    <script>

        function openBayar(
            id,
            lapangan,
            tanggal,
            jamMulai,
            jamSelesai,
            total
        ) {

            document.getElementById("bayarModal")
                .style.display = "flex";

            document.getElementById("idBooking")
                .value = id;

            document.getElementById("namaLapangan")
                .value = lapangan;

            document.getElementById("tanggal")
                .value = tanggal;

            document.getElementById("jam")
                .value = jamMulai + " - " + jamSelesai;

            document.getElementById("totalBayar")
                .value = "Rp" + total;

            document.getElementById("totalBayarHidden")
                .value = total;
        }

        function closeBayar() {

            document.getElementById("bayarModal")
                .style.display = "none";
        }

    </script>

    <script src="../asset/js/script.js"></script>

</body>

</html>