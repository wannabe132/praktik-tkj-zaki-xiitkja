<?php
session_start();
require_once "config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    /* =========================
       CARI USERNAME
    ========================= */

    $sql = "SELECT * FROM tuser
            WHERE Username = ?";

    $stmt = mysqli_prepare($koneksi, $sql);

    mysqli_stmt_bind_param($stmt, "s", $Username);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    /* =========================
       USER ADA?
    ========================= */

    if (mysqli_num_rows($result) > 0) {

        $data = mysqli_fetch_assoc($result);

        /* =========================
           CEK PASSWORD HASH
        ========================= */

        if (password_verify($Password, $data['Password'])) {

            // SESSION
            $_SESSION['Username'] = $data['Username'];
            $_SESSION['Role'] = $data['Role'];

            /* =========================
               REDIRECT ROLE
            ========================= */

            if ($data['Role'] == 'Admin') {

                header("Location: Admin/Dashboard_admin.php");

            } else {

                header("Location: User/Dashboard_user.php");
            }

            exit;

        } else {

            echo "<script>
                alert('Password salah!');
                window.location.href='Index.php';
            </script>";
        }

    } else {

        echo "<script>
            alert('Username tidak ditemukan!');
            window.location.href='Index.php';
        </script>";
    }

    mysqli_stmt_close($stmt);
}
?>