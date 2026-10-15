<?php
session_start();
require_once("../config/koneksi.php");

// CEK ADMIN
if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: ../Index.php");
    exit;
}

$id = $_GET['id'];

// JOIN biar tampil nama lapangan
$query = "SELECT tbooking.*, tlapang.Nama_lapangan 
          FROM tbooking 
          JOIN tlapang ON tbooking.Id_lapang = tlapang.Id_lapang
          WHERE tbooking.Id_booking = '$id'";

$data = mysqli_fetch_assoc(mysqli_query($koneksi, $query));
?>

<h2>Detail Booking</h2>

<p><b>User:</b> <?= $data['Username']; ?></p>
<p><b>Lapangan:</b> <?= $data['Nama_lapangan']; ?></p>
<p><b>Tanggal:</b> <?= $data['Tanggal']; ?></p>
<p><b>Jam:</b> <?= $data['Jam_mulai']; ?> - <?= $data['Jam_selesai']; ?></p>
<p><b>Status:</b> <?= $data['Status']; ?></p>

<br>

<?php if($data['Status'] == 'menunggu') { ?>
    <a href="Action/Approve_booking.php?id=<?= $data['Id_booking']; ?>">Approve</a> |
    <a href="Action/Tolak_booking.php?id=<?= $data['Id_booking']; ?>">Tolak</a>
<?php } ?>

<br><br>
<a href="Booking_admin.php">Kembali</a>