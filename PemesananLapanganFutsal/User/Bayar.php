<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../Index.php");
    exit;
}

$id_booking = $_GET['id'];

$query = "SELECT tbooking.*, tlapang.Nama_lapangan, tlapang.Harga
FROM tbooking
INNER JOIN tlapang ON tbooking.Id_lapang = tlapang.Id_lapang
WHERE tbooking.Id_booking='$id_booking'";

$data = mysqli_fetch_assoc(mysqli_query($koneksi, $query));

/* =========================
   VALIDASI STATUS
========================= */
if (strtolower($data['Status']) != 'disetujui') {
    echo "<script>
        alert('Booking belum disetujui admin!');
        window.location.href='Transaksi_user.php';
    </script>";
    exit;
}

/* =========================
   TOTAL
========================= */
$jamMulai = strtotime($data['Jam_mulai']);
$jamSelesai = strtotime($data['Jam_selesai']);
$durasi = ($jamSelesai - $jamMulai) / 3600;
$totalBayar = $durasi * $data['Harga'];
?>

<h2>Pembayaran</h2>

<form action="Action/Proses_pembayaran.php" method="POST">

    <input type="hidden" name="Id_booking" value="<?= $data['Id_booking']; ?>">
    <input type="hidden" name="Total_bayar" value="<?= $totalBayar; ?>">

    <p>Lapangan: <?= $data['Nama_lapangan']; ?></p>
    <p>Tanggal: <?= $data['Tanggal']; ?></p>
    <p>Jam: <?= $data['Jam_mulai']; ?> - <?= $data['Jam_selesai']; ?></p>
    <p>Total: Rp<?= number_format($totalBayar); ?></p>

    <select name="Metode_pembayaran" required>
        <option value="Bank Bjb">Bank Bjb</option>
        <option value="Transfer">Transfer</option>
        <option value="E-Wallet">E-Wallet</option>
    </select>

    <input type="number" name="Nominal" placeholder="Nominal" required>

    <button type="submit">Bayar</button>

</form>