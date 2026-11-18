
<?php

require_once "config/auth.php";

// Jika belum login, arahkan ke login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: login.php");
    exit;
}

// Arahkan berdasarkan peran
if ($_SESSION['peran'] === 'penyewa') {
    header("Location: penyewa/dashboard.php");
} else {
    header("Location: admin/dashboard.php");
}

exit;
