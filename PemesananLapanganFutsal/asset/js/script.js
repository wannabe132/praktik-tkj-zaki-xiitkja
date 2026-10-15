/* =========================
   LOGIN
========================= */

function openLogin() {
    document.getElementById("loginModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("loginModal").style.display = "none";
}

/* =========================
   REGISTER
========================= */

function showRegister() {
    document.getElementById("loginModal").style.display = "none";
    document.getElementById("registerModal").style.display = "flex";
}

function closeRegister() {
    document.getElementById("registerModal").style.display = "none";
}

/* =========================
   BALIK KE LOGIN
========================= */

function showLogin() {
    document.getElementById("registerModal").style.display = "none";
    document.getElementById("loginModal").style.display = "flex";
}

function konfirmasiLogout() {
    return confirm("Yakin mau logout?");
}


/* =========================
   EDIT PROFILE MODAL
========================= */

function OpenEditProfile() {
    document.getElementById("editProfileModal").style.display = "flex";
}

function closeEditProfile() {
    document.getElementById("editProfileModal").style.display = "none";
}


/* =========================
   BAYAR MODAL
========================= */

function openBayar(id, lapangan, tanggal, mulai, selesai, total) {

    document.getElementById("bayarModal").style.display = "flex";

    document.getElementById("idBooking").value = id;

    document.getElementById("namaLapangan").value = lapangan;

    document.getElementById("tanggal").value = tanggal;

    document.getElementById("jam").value =
        mulai + " - " + selesai;

    document.getElementById("totalBayar").value =
        "Rp " + parseInt(total).toLocaleString();

    document.getElementById("totalBayarHidden").value =
        total;
}

function closeBayar() {

    document.getElementById("bayarModal").style.display = "none";
}