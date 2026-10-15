<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../Index.php");
    exit;
}

$username = $_SESSION['Username'];

$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM tuser WHERE Username='$username'")
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../asset/css/style.css">
</head>

<body>

<div class="profile-container">

    <div class="profile-card">

        <h2>Edit Profile</h2>

        <form action="Action/Proses_edit_profile.php" method="POST">

            <!-- USERNAME LAMA (hidden) -->
            <input type="hidden" name="username_lama" value="<?= $data['Username']; ?>">

            <label>Username</label>
            <input type="text" name="Username" value="<?= $data['Username']; ?>" required>

            <label>Password Baru (kosongkan jika tidak ganti)</label>
            <input type="password" name="Password" placeholder="Password baru">

            <button type="submit" class="edit-profile-btn">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>

</body>
</html>