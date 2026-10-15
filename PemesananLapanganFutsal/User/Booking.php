<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'User') {
    header("Location: ../Index.php");
    exit;
}

$id = $_GET['Id_lapang'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Booking</title>
</head>

<script>
function isiHariIni() {

    let today = new Date();

    let tahun = today.getFullYear();

    let bulan = String(today.getMonth() + 1).padStart(2, '0');

    let hari = String(today.getDate()).padStart(2, '0');

    let tanggal = tahun + "-" + bulan + "-" + hari;

    document.getElementById("Tanggal").value = tanggal;
}
</script>

<body>

    <h2>Booking Lapangan</h2>

    <form action="Action/Proses_booking.php" method="POST">

        <input type="hidden" name="Id_lapang" value="<?= $id ?>">

        <label>Tanggal:</label><br>
        <input type="date" name="Tanggal" id="Tanggal" min="<?= date('Y-m-d'); ?>" required>
        <button type="button" onclick="isiHariIni()">
            Today
        </button>
        <br><br>

        <label>Jam Mulai:</label><br>
        <input type="time" name="Jam_mulai" required><br><br>

        <label>Jam Selesai:</label><br>
        <input type="time" name="Jam_selesai" required><br><br>

        <button type="submit">Booking</button>
    </form>

</body>

</html>