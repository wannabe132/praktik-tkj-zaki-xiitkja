<?php
session_start();
require_once("../config/koneksi.php");

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 'User') {
    header("Location: ../Index.php");
    exit;
}

$query = "SELECT * FROM tlapang";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Daftar Lapangan</title>

    <link rel="stylesheet" href="../asset/css/style.css">

    <!-- FLATPICKR -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>

<body>

    <!-- NAVBAR -->

    <div class="navbar-user">

        <h2>AYO</h2>

        <div class="navbar-menu">

            <a href="Dashboard_user.php">
                Home
            </a>

            <a href="Lapangan_user.php">
                Lapangan
            </a>

            <a href="Jadwal.php">
                Jadwal
            </a>

            <a href="Booking_user.php">
                Booking Saya
            </a>

            <a href="Transaksi_user.php">
                Transaksi
            </a>

            <a href="Profile.php">
                Profile
            </a>

            <a href="../Logout.php" onclick="return confirm('Yakin ingin logout?')">

                <button class="logout-btn">
                    Logout
                </button>

            </a>

        </div>

    </div>

    <!-- CONTAINER -->

    <div class="container">

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <div class="card">

                <img src="../asset/img/<?= $row['Gambar']; ?>">

                <div class="card-body">

                    <h3>
                        <?= $row['Nama_lapangan']; ?>
                    </h3>

                    <p>
                        Rp<?= number_format($row['Harga']); ?> / Jam
                    </p>

                    <p>
                        <?= $row['Deskripsi']; ?>
                    </p>

                    <!-- BUTTON BOOKING -->

                    <button onclick="openBooking(

            '<?= $row['Id_lapang']; ?>',

            '<?= $row['Nama_lapangan']; ?>'

            )">

                        Booking Sekarang

                    </button>

                </div>

            </div>

        <?php } ?>

    </div>

    <!-- MODAL BOOKING -->

    <div id="bookingModal" class="modal">

        <div class="modal-content">

            <span class="close" onclick="closeBooking()">

                &times;

            </span>

            <h3>Booking Lapangan</h3>

            <form action="Action/Proses_booking.php" method="POST">

                <!-- ID LAPANGAN -->

                <input type="hidden" name="Id_lapang" id="idLapangan">

                <!-- NAMA LAPANGAN -->

                <label>Lapangan</label>

                <input type="text" id="namaLapangan" readonly>

                <!-- TANGGAL -->

                <label>Tanggal</label>

                <input type="text" id="tanggalBooking" name="Tanggal" placeholder="Pilih Tanggal" required>

                <!-- BUTTON TODAY -->

                <button type="button" onclick="isiHariIni()">

                    Today

                </button>

                <br><br>

                <!-- JAM MULAI -->

                <label>Jam Mulai</label>

                <input type="time" name="Jam_mulai" id="jamMulai" min="08:00" max="22:00" required>

                <!-- JAM SELESAI -->

                <label>Jam Selesai</label>

                <input type="time" name="Jam_selesai" id="jamSelesai" min="08:00" max="22:00" required>

                <button type="submit">

                    Booking Sekarang

                </button>

            </form>

        </div>

    </div>

    <!-- JAVASCRIPT -->

    <script>

        function openBooking(id, nama) {

            document.getElementById("bookingModal")
                .style.display = "flex";

            document.getElementById("idLapangan")
                .value = id;

            document.getElementById("namaLapangan")
                .value = nama;
        }

        function closeBooking() {

            document.getElementById("bookingModal")
                .style.display = "none";
        }

        /* =========================
           TODAY BUTTON
        ========================= */

        function isiHariIni() {

            let today = new Date();

            let tahun = today.getFullYear();

            let bulan = String(
                today.getMonth() + 1
            ).padStart(2, '0');

            let hari = String(
                today.getDate()
            ).padStart(2, '0');

            let tanggal =
                tahun + "-" + bulan + "-" + hari;

            document.getElementById(
                "tanggalBooking"
            ).value = tanggal;
        }

        /* =========================
           VALIDASI JAM
        ========================= */

        const jamMulai =
            document.getElementById("jamMulai");

        const jamSelesai =
            document.getElementById("jamSelesai");

        jamMulai.addEventListener("change", function () {

            if (
                this.value < "08:00" ||
                this.value > "22:00"
            ) {

                alert(
                    "Booking hanya tersedia pukul 08:00 - 22:00"
                );

                this.value = "";
            }
        });

        jamSelesai.addEventListener("change", function () {

            if (
                this.value < "08:00" ||
                this.value > "22:00"
            ) {

                alert(
                    "Booking hanya tersedia pada pukul 08:00 - 22:00"
                );

                this.value = "";
            }
        });

    </script>



    <!-- FLATPICKR -->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        flatpickr("#tanggalBooking", {

            minDate: "today",

            dateFormat: "Y-m-d",

            disableMobile: true
        });

    </script>

</body>

</html>