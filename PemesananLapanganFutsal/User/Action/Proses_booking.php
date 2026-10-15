<?php
session_start();
require_once("../../config/koneksi.php");

// CEK LOGIN
if (!isset($_SESSION['Username'])) {
    header("Location: ../../Index.php");
    exit;
}

// AMBIL DATA
$Username = $_SESSION['Username'];
$Id_lapang = $_POST['Id_lapang'];
$Tanggal = $_POST['Tanggal'];
$Jam_mulai = $_POST['Jam_mulai'];
$Jam_selesai = $_POST['Jam_selesai'];

// =========================
// VALIDASI INPUT KOSONG
// =========================
if (!$Id_lapang || !$Tanggal || !$Jam_mulai || !$Jam_selesai) {
    echo "<script>
        alert('Data tidak lengkap!');
        window.history.back();
    </script>";
    exit;
}

// =========================
// VALIDASI JAM LOGIS
// =========================
if ($Jam_mulai >= $Jam_selesai) {
    echo "<script>
        alert('Jam tidak valid!');
        window.history.back();
    </script>";
    exit;
}

// =========================
// VALIDASI TANGGAL (TIDAK BOLEH MASA LALU)
// =========================
$today = date("Y-m-d");

if ($Tanggal < $today) {
    echo "<script>
        alert('Tidak bisa booking di masa lalu!');
        window.history.back();
    </script>";
    exit;
}

// =========================
// VALIDASI JAM OPERASIONAL
// =========================
if ($Jam_mulai < "08:00" || $Jam_selesai > "22:00") {
    echo "<script>
        alert('Jam di luar operasional! (08:00 - 22:00)');
        window.history.back();
    </script>";
    exit;
}


/* =========================
   CEK BOOKING BENTROK
========================= */

$cek = mysqli_query(

    $koneksi,

    "SELECT * FROM tbooking

    WHERE Id_lapang='$Id_lapang'

    AND Tanggal='$Tanggal'

    AND Status != 'ditolak'

    AND (

        ('$Jam_mulai' >= Jam_mulai
        AND '$Jam_mulai' < Jam_selesai)

        OR

        ('$Jam_selesai' > Jam_mulai
        AND '$Jam_selesai' <= Jam_selesai)

        OR

        (Jam_mulai >= '$Jam_mulai'
        AND Jam_mulai < '$Jam_selesai')

    )"
);

/* =========================
   JIKA BENTROK
========================= */

if (mysqli_num_rows($cek) > 0) {

    echo "<script>

        alert('Jadwal booking bentrok! Pilih jam lain.');

        window.history.back();

    </script>";

    exit;
}

// =========================
// SIMPAN DATA
// =========================
$query = "INSERT INTO tbooking 
(Username, Id_lapang, Tanggal, Jam_mulai, Jam_selesai, Status)
VALUES 
('$Username', '$Id_lapang', '$Tanggal', '$Jam_mulai', '$Jam_selesai', 'menunggu')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
        alert('Booking berhasil!');
        window.location.href='../Lapangan_user.php';
    </script>";
} else {
    echo "<script>
        alert('Booking gagal!');
        window.history.back();
    </script>";
}
?>