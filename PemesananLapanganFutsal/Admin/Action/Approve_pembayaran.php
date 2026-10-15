<?php
require_once("../../config/koneksi.php");

$id = $_GET['id'];

/* =========================
   UPDATE TRANSAKSI
========================= */

mysqli_query($koneksi, "

UPDATE ttransaksi

SET Status_pembayaran='lunas'

WHERE Id_transaksi='$id'

");

echo "<script>

alert('Pembayaran disetujui!');

window.location.href='../Pembayaran_admin.php';

</script>";
?>