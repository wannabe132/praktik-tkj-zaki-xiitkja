<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../Index.php");
    exit;
}

$id = $_GET['id'];

/* =========================
   AMBIL DATA TRANSAKSI
========================= */

$query = mysqli_query($koneksi, "
SELECT 
tbooking.*,
tlapang.Nama_lapangan,
tlapang.Harga,
ttransaksi.Metode_pembayaran,
ttransaksi.Nominal,
ttransaksi.Status_pembayaran

FROM tbooking
JOIN tlapang ON tbooking.Id_lapang = tlapang.Id_lapang
LEFT JOIN ttransaksi ON tbooking.Id_booking = ttransaksi.Id_booking

WHERE tbooking.Id_booking = '$id'
");

$data = mysqli_fetch_assoc($query);

/* =========================
   HITUNG TOTAL
========================= */

$jam1 = strtotime($data['Jam_mulai']);
$jam2 = strtotime($data['Jam_selesai']);
$durasi = ($jam2 - $jam1) / 3600;
$total = $durasi * $data['Harga'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 30px;
        }

        .box {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 10px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background: #ff7a00;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
        }

        .status {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="box">

        <h2>INVOICE PEMBAYARAN AYO</h2>

        <div class="row"><b>Lapangan:</b> <?= $data['Nama_lapangan']; ?></div>
        <div class="row"><b>Tanggal:</b> <?= $data['Tanggal']; ?></div>
        <div class="row"><b>Jam:</b> <?= $data['Jam_mulai']; ?> - <?= $data['Jam_selesai']; ?></div>
        <div class="row"><b>Durasi:</b> <?= $durasi; ?> Jam</div>

        <hr>

        <div class="row"><b>Total Harga:</b> Rp<?= number_format($total); ?></div>
        <div class="row"><b>Metode:</b> <?= $data['Metode_pembayaran'] ?? '-'; ?></div>
        <div class="row"><b>Nominal Dibayar:</b> Rp<?= number_format($data['Nominal'] ?? 0); ?></div>

        <div class="row">
            <b>Status:</b>
            <span class="status">
                <?= $data['Status_pembayaran'] ?? 'Belum Bayar'; ?>
            </span>
        </div>

        <button class="btn" onclick="window.print()">
            Print Invoice
        </button>

    </div>

</body>

</html>