<?php

require_once __DIR__ . '/config/auth.php';

// Jika sudah login, arahkan sesuai peran
if (isset($_SESSION['pengguna'])) {
    $peran = $_SESSION['pengguna']['peran'];

    if ($peran === 'penyewa') {
        header('Location: penyewa/dashboard.php');
    } else {
        header('Location: admin/dashboard.php');
    }

    exit;
}

// Mengambil pesan login
$pesan = $_SESSION['pesan_login'] ?? null;

unset($_SESSION['pesan_login']);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ranaya Outdoor</title>
</head>

<body>

    <h1>Login Ranaya Outdoor</h1>

    <p>Silakan masuk untuk melanjutkan penyewaan perlengkapan outdoor.</p>

    <?php if ($pesan): ?>
        <p style="color: red;">
            <?= htmlspecialchars($pesan) ?>
        </p>
    <?php endif; ?>

    <form action="proses/login.php" method="POST">

        <label for="email">Email</label><br>

        <input
            type="email"
            id="email"
            name="email"
            maxlength="80"
            required
        >

        <br><br>

        <label for="password">Password</label><br>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">Login</button>

    </form>

    <p>
        Belum memiliki akun?
        <a href="register.php">Daftar sekarang</a>
    </p>

</body>

</html>
