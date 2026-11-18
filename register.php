
<?php
session_start();

if (isset($_SESSION['pengguna'])) {
    header('Location: index.php');
    exit;
}

$pesan = $_SESSION['pesan_register'] ?? null;
$jenisPesan = $_SESSION['jenis_pesan'] ?? 'error';

unset($_SESSION['pesan_register'], $_SESSION['jenis_pesan']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Ranaya Outdoor</title>
</head>
<body>

    <h1>Daftar Akun Ranaya Outdoor</h1>
    <p>Buat akun untuk mulai menyewa perlengkapan outdoor.</p>

    <?php if ($pesan): ?>
        <p style="color: <?= $jenisPesan === 'success' ? 'green' : 'red' ?>">
            <?= htmlspecialchars($pesan) ?>
        </p>
    <?php endif; ?>

    <form action="proses/register.php" method="POST">

        <label for="nama">Nama Lengkap</label><br>
        <input
            type="text"
            id="nama"
            name="nama"
            maxlength="50"
            required
        ><br><br>

        <label for="email">Email</label><br>
        <input
            type="email"
            id="email"
            name="email"
            maxlength="80"
            required
        ><br><br>

        <label for="no_telepon">Nomor Telepon</label><br>
        <input
            type="tel"
            id="no_telepon"
            name="no_telepon"
            maxlength="20"
            required
        ><br><br>

        <label for="password">Password</label><br>
        <input
            type="password"
            id="password"
            name="password"
            minlength="8"
            required
        ><br><br>

        <label for="konfirmasi_password">Konfirmasi Password</label><br>
        <input
            type="password"
            id="konfirmasi_password"
            name="konfirmasi_password"
            minlength="8"
            required
        ><br><br>

        <button type="submit">Daftar</button>

    </form>

    <p>
        Sudah memiliki akun?
        <a href="login.php">Login di sini</a>
    </p>

</body>
</html>
