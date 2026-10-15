<?php
require_once("config/koneksi.php");

/* =========================
   AMBIL DATA
========================= */

$Username = $_POST['Username'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$Konfirmasi = $_POST['Konfirmasi'];

/* =========================
   CEK PASSWORD SAMA
========================= */

if($Password != $Konfirmasi){

    echo "<script>
        alert('Konfirmasi password tidak sama!');
        window.history.back();
    </script>";

    exit;
}

/* =========================
   HASH PASSWORD
========================= */

$hash = password_hash($Password, PASSWORD_DEFAULT);

/* =========================
   CEK USERNAME
========================= */

$cek = mysqli_query(
    $koneksi,
    "SELECT * FROM tuser
     WHERE Username='$Username' OR Email='$Email'"
);

if(mysqli_num_rows($cek) > 0){

    echo "<script>
        alert('Username sudah digunakan!');
        window.history.back();
    </script>";

    exit;
}

/* =========================
   INSERT USER
========================= */

$query = "INSERT INTO tuser
(Username, Email, Password, Role)

VALUES

('$Username', '$Email', '$hash', 'User')";

$hasil = mysqli_query($koneksi, $query);

/* =========================
   HASIL
========================= */

if($hasil){

    echo "<script>
        alert('Register berhasil!');
        window.location.href='Index.php?login=1';
    </script>";

}else{

    echo "<script>
        alert('Register gagal!');
        window.history.back();
    </script>";
}
?>