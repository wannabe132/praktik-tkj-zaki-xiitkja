<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: ../Index.php");
    exit;
}

include "Layout_admin.php";

$query = "SELECT * FROM tlapang";
$result = mysqli_query($koneksi, $query);
?>

<h1>Kelola Lapangan</h1>

<form action="Action/Tambah_lapangan.php" method="POST" enctype="multipart/form-data">

    <input type="text" name="Nama_lapangan" placeholder="Nama Lapangan">

    <br><br>

    <input type="number" name="Harga" placeholder="Harga">

    <br><br>

    <textarea name="Deskripsi" placeholder="Deskripsi"></textarea>

    <br><br>

    <input type="file" name="Gambar">

    <br><br>

    <button type="submit">
        Tambah
    </button>

</form>

<br><br>

<div class="table-container">

    <table class="table-lapangan">

        <tr>

            <th>No</th>

            <th>Gambar</th>

            <th>Nama</th>

            <th>Harga</th>

            <th>Deskripsi</th>

            <th>Aksi</th>

        </tr>

        <?php
        $no = 1;

        while ($row = mysqli_fetch_assoc($result)) {
            ?>

            <tr>

                <td>
                    <?= $no++; ?>
                </td>

                <td>

                    <img src="../asset/img/<?= $row['Gambar']; ?>">

                </td>

                <td>

                    <?= $row['Nama_lapangan']; ?>

                </td>

                <td>

                    Rp<?= number_format($row['Harga']); ?>

                </td>

                <td>

                    <?= $row['Deskripsi']; ?>

                </td>

                <td class="aksi">

                    <!-- BUTTON EDIT -->

                    <button class="icon-edit" onclick="openEdit(

                    '<?= $row['Id_lapang']; ?>',

                    '<?= $row['Nama_lapangan']; ?>',

                    '<?= $row['Harga']; ?>',

                    '<?= $row['Deskripsi']; ?>'

                    )">

                        <i class="fa-solid fa-pen"></i>

                    </button>

                    <!-- BUTTON HAPUS -->

                    <a href="Action/Hapus_lapangan.php?id=<?= $row['Id_lapang']; ?>"
                        onclick="return confirm('Yakin ingin hapus lapangan ini?')">

                        <button class="icon-delete">

                            <i class="fa-solid fa-trash"></i>

                        </button>

                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

</div>

<!-- MODAL EDIT -->

<div id="editModal" class="modal">

    <div class="modal-content">

        <span class="close" onclick="closeEdit()">

            &times;

        </span>

        <h2>Edit Lapangan</h2>

        <form action="Action/Update_lapangan.php" method="POST">

            <input type="hidden" name="Id_lapang" id="editId">

            <input type="text" name="Nama_lapangan" id="editNama" placeholder="Nama Lapangan">

            <br><br>

            <input type="number" name="Harga" id="editHarga" placeholder="Harga">

            <br><br>

            <textarea name="Deskripsi" id="editDeskripsi" placeholder="Deskripsi"></textarea>

            <br><br>

            <button type="submit">

                Simpan

            </button>

        </form>

    </div>

</div>

<script>

    function openEdit(id, nama, harga, deskripsi) {

        document.getElementById("editModal")
            .style.display = "flex";

        document.getElementById("editId")
            .value = id;

        document.getElementById("editNama")
            .value = nama;

        document.getElementById("editHarga")
            .value = harga;

        document.getElementById("editDeskripsi")
            .value = deskripsi;
    }

    function closeEdit() {

        document.getElementById("editModal")
            .style.display = "none";
    }

</script>

<?php include "Footer_admin.php"; ?>