<?php
session_start();
require_once("../../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../../Index.php");
    exit;
}

$username_lama = $_POST['username_lama'];
$username_baru = $_POST['Username'];
$password = $_POST['Password'];

/* =========================
   CEK USERNAME DIPAKAI ORANG LAIN
========================= */

$cek = mysqli_query(
    $koneksi,
    "SELECT * FROM tuser 
     WHERE Username='$username_baru' 
     AND Username!='$username_lama'"
);

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Username sudah dipakai!');
        window.history.back();
    </script>";
    exit;
}

/* =========================
   UPDATE DATA
========================= */

if ($password != "") {

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE tuser SET 
        Username='$username_baru',
        Password='$hash'
        WHERE Username='$username_lama'";

} else {

    $query = "UPDATE tuser SET 
        Username='$username_baru'
        WHERE Username='$username_lama'";
}

$update = mysqli_query($koneksi, $query);

/* =========================
   UPDATE SESSION
========================= */

if ($update) {

    $_SESSION['Username'] = $username_baru;

    echo "<script>
        alert('Profile berhasil diupdate!');
        window.location.href='../Profile.php';
    </script>";

} else {

    echo "<script>
        alert('Gagal update profile!');
        window.history.back();
    </script>";
}
?>