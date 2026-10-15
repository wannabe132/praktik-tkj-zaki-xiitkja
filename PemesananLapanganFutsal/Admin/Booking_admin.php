<?php
session_start();
require_once("../config/koneksi.php");

/* =========================
   CEK LOGIN ADMIN
========================= */

if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: ../Index.php");
    exit;
}

/* =========================
   PANGGIL LAYOUT
========================= */
include "Layout_admin.php";


/* =========================
   SEARCH & FILTER
========================= */
$search = "";
$status = "";

/* SEARCH */
if(isset($_GET['search'])){
    $search = $_GET['search'];
}

/* FILTER STATUS */
if(isset($_GET['status'])){
    $status = $_GET['status'];
}

/* QUERY */
$query = "SELECT *
FROM tbooking
INNER JOIN tlapang
ON tbooking.Id_lapang =
tlapang.Id_lapang
WHERE Username LIKE '%$search%'";

/* FILTER STATUS */
if($status != ""){
    $query .=
    " AND Status='$status'";
}

$query .=
" ORDER BY Id_booking DESC";



$result = mysqli_query($koneksi, $query);
?>

<h1>Kelola Booking</h1>

<hr>


<!-- SEARCH & FILTER -->
<form method="GET"
      class="filter-form">

    <!-- SEARCH -->
    <input type="text"
           name="search"
           placeholder="Cari username..."
           value="<?= $search; ?>">

    <!-- FILTER -->
    <select name="status">
        <option value="">
            Semua Status
        </option>

        <option value="menunggu"
        <?= $status == 'menunggu'
        ? 'selected' : ''; ?>>
            Menunggu
        </option>

        <option value="disetujui"
        <?= $status == 'disetujui'
        ? 'selected' : ''; ?>>
            Disetujui
        </option>

        <option value="ditolak"
        <?= $status == 'ditolak'
        ? 'selected' : ''; ?>>
            Ditolak
        </option>
    </select>

    <button type="submit">
        Cari
    </button>

</form>

<br>



<div class="table-container">
    <table border="1" cellpadding="10">

        <tr>
            <th>No</th>
            <th>User</th>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            ?>

            <tr>

                <td><?= $no++; ?></td>

                <td>
                    <?= $row['Username']; ?>
                </td>

                <td>
                    <?= $row['Nama_lapangan']; ?>
                </td>

                <td>
                    <?= $row['Tanggal']; ?>
                </td>

                <td>
                    <?= $row['Jam_mulai']; ?>
                    -
                    <?= $row['Jam_selesai']; ?>
                </td>

                <td>
                    <?= $row['Status']; ?>
                </td>

                <td>

                    <?php if ($row['Status'] == 'menunggu') { ?>

                        <!-- Approve -->
                        <a href="Action/Approve_booking.php?id=<?= $row['Id_booking']; ?>">
                            Approve
                        </a>

                        |
                        <!-- Disapprove -->
                        <a href="Action/Disapprove_booking.php?id=<?= $row['Id_booking']; ?>">
                            Disapprove
                        </a>

                    <?php } else { ?>

                        -

                    <?php } ?>

                </td>

            </tr>

        <?php } ?>

    </table>
</div>

<?php include "Footer_admin.php"; ?>