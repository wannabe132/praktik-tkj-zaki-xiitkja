<?php
session_start();
require_once("../../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../../Index.php");
    exit;
}

$id_booking = $_POST['Id_booking'];
$metode = $_POST['Metode_pembayaran'];
$nominal = $_POST['Nominal'];
$total = $_POST['Total_bayar'];

/* =========================
   UPLOAD BUKTI
========================= */

$namaFile = $_FILES['Bukti_pembayaran']
['name'];

$tmp = $_FILES['Bukti_pembayaran']
['tmp_name'];

move_uploaded_file($tmp, "../../asset/bukti/" . $namaFile);

/* =========================
   VALIDASI NOMINAL
========================= */
if ($nominal < $total) {
    echo "<script>
        alert('Nominal kurang!');
        window.history.back();
    </script>";
    exit;
}

/* =========================
   CEK SUDAH BAYAR
========================= */
$cek = mysqli_query($koneksi, "SELECT * FROM ttransaksi WHERE Id_booking='$id_booking'");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Sudah dibayar!');
        window.location.href='../Transaksi_user.php';
    </script>";
    exit;
}

/* =========================
   INSERT TRANSAKSI (FIX TANGGAL)
========================= */
$query = "INSERT INTO ttransaksi

(
Id_booking,
Metode_pembayaran,
Nominal,
Bukti_pembayaran,
Status_pembayaran
)

VALUES

(
'$id_booking',
'$metode',
'$nominal',
'$namaFile',
'menunggu'
)";

$hasil = mysqli_query($koneksi, $query);

if ($hasil) {

    echo "<script>
        alert('Pembayaran berhasil!');
        window.location.href='../Transaksi_user.php';
    </script>";

} else {

    echo "<script>
        alert('Gagal bayar!');
        window.history.back();
    </script>";
}
?>