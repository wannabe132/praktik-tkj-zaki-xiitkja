<!DOCTYPE html>
<html>

<head>
    <title>AYO Futsal</title>
    <link rel="stylesheet" href="asset/css/style.css">
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <h2>AYO</h2>
        <div>
            <button onclick="openLogin()">Masuk</button>
        </div>
    </div>

    <!-- HERO -->
    <div class="hero">
        <div class="overlay">
            <h1>Super Sport<br>Community App</h1>
            <p>Booking lapangan jadi mudah</p>
        </div>
    </div>

    <!-- FITUR -->

    <div class="fitur-section">

        <h2>
            Kenapa Pilih AYO?
        </h2>

        <div class="fitur-grid">

            <div class="fitur-card">

                <div class="fitur-icon">

                    ⚡

                </div>

                <h3>Booking Cepat</h3>

                <p>

                    Booking lapangan jadi lebih mudah
                    dan praktis secara online.

                </p>

            </div>

            <div class="fitur-card">

                <div class="fitur-icon">

                    ⚽

                </div>

                <h3>Lapangan Berkualitas</h3>

                <p>

                    Pilihan lapangan terbaik
                    dengan kualitas premium.

                </p>

            </div>

            <div class="fitur-card">

                <div class="fitur-icon">

                    🔒

                </div>

                <h3>Aman & Nyaman</h3>

                <p>

                    Sistem booking aman
                    dan mudah digunakan.

                </p>

            </div>

        </div>

    </div>

    <!-- CTA -->

    <div class="cta-section">

        <h2>

            Siap Main Hari Ini?

        </h2>

        <p>

            Booking lapangan favoritmu sekarang juga

        </p>

        <button onclick="openLogin()">

            Booking Sekarang

        </button>

    </div>

    <!-- FOOTER -->

    <div class="footer">

        <h3>AYO Futsal</h3>

        <p>

            Super Sport Community App

        </p>

    </div>

    <!-- MODAL LOGIN -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span onclick="closeModal()" class="close">&times;</span>
            <h3>Masuk</h3>

            <form action="Login_proses.php" method="POST">
                <input type="text" name="Username" placeholder="Username">
                <br><br>
                <input type="password" name="Password" placeholder="Password">
                <br><br>
                <button type="submit">
                    Login
                </button>
            </form>
            <br>
            <p>
                Belum punya akun?

                <a href="javascript:void(0)" onclick="showRegister()">

                    Daftar

                </a>
            </p>

        </div>
    </div>

    <!-- MODAL REGISTER -->
    <div id="registerModal" class="modal">

        <div class="modal-content">

            <span onclick="closeRegister()" class="close">
                &times;
            </span>

            <h3>Register</h3>

            <form action="Register_proses.php" method="POST">
                <input type="text" name="Username" placeholder="Masukkan Username" required>
                <br><br>
                <input type="email" name="Email" placeholder="Masukkan Email" required>
                <br><br>
                <input type="password" name="Password" placeholder="Masukkan Password" required>
                <br><br>
                <input type="password" name="Konfirmasi" placeholder="Konfirmasi Password" required>
                <br><br>
                <button type="submit">
                    Daftar
                </button>
            </form>
            <br>
            <p>
                Sudah punya akun?
                <a href="javascript:void(0)" onclick="showLogin()">
                    Login
                </a>
            </p>

        </div>

    </div>

    <?php if (isset($_GET['login'])) { ?>
        <script>
            window.onload = function () {
                openLogin();
            }
        </script>

    <?php } ?>

    <script src="asset/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>