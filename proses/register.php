
<?php

session_start();

require_once __DIR__ . '/../config/database.php';

// Memastikan formulir dikirim menggunakan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit;
}

// Mengambil dan membersihkan input
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$noTelepon = trim($_POST['no_telepon'] ?? '');
$password = $_POST['password'] ?? '';
$konfirmasiPassword = $_POST['konfirmasi_password'] ?? '';

// Fungsi untuk mengirim pesan dan kembali ke registrasi
function gagalRegister($pesan)
{
    $_SESSION['pesan_register'] = $pesan;
    $_SESSION['jenis_pesan'] = 'error';

    header('Location: ../register.php');
    exit;
}

// Validasi nama
if ($nama === '' || strlen($nama) > 50) {
    gagalRegister('Nama wajib diisi dan maksimal 50 karakter.');
}

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 80) {
    gagalRegister('Format email tidak valid.');
}

// Validasi nomor telepon
if (!preg_match('/^[0-9+]{10,20}$/', $noTelepon)) {
    gagalRegister('Nomor telepon harus berisi 10-20 digit atau tanda +.');
}

// Validasi password
if (strlen($password) < 8 || strlen($password) > 72) {
    gagalRegister('Password harus memiliki 8-72 karakter.');
}

// Memeriksa kesesuaian password
if ($password !== $konfirmasiPassword) {
    gagalRegister('Konfirmasi password tidak sesuai.');
}

try {

    // Memeriksa apakah email sudah digunakan
    $queryEmail = "SELECT id_pengguna
                   FROM pengguna
                   WHERE email = :email
                   LIMIT 1";

    $stmtEmail = $pdo->prepare($queryEmail);
    $stmtEmail->execute([':email' => $email]);

    if ($stmtEmail->fetch()) {
        gagalRegister('Email sudah terdaftar.');
    }

    // Memeriksa apakah nomor telepon sudah digunakan
    $queryTelepon = "SELECT id_pengguna
                     FROM pengguna
                     WHERE no_telepon = :telepon
                     LIMIT 1";

    $stmtTelepon = $pdo->prepare($queryTelepon);
    $stmtTelepon->execute([':telepon' => $noTelepon]);

    if ($stmtTelepon->fetch()) {
        gagalRegister('Nomor telepon sudah terdaftar.');
    }

    // Membuat ID pengguna sepanjang 32 karakter
    $idPengguna = bin2hex(random_bytes(16));

    // Mengamankan password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan pengguna baru
    $queryInsert = "INSERT INTO pengguna
                    (
                        id_pengguna,
                        nama,
                        email,
                        no_telepon,
                        password,
                        peran,
                        status_akun
                    )
                    VALUES
                    (
                        :id,
                        :nama,
                        :email,
                        :telepon,
                        :password,
                        'penyewa',
                        'aktif'
                    )";

    $stmtInsert = $pdo->prepare($queryInsert);

    $stmtInsert->execute([
        ':id' => $idPengguna,
        ':nama' => $nama,
        ':email' => $email,
        ':telepon' => $noTelepon,
        ':password' => $passwordHash
    ]);

    // Menyimpan pesan keberhasilan
    $_SESSION['pesan_register'] = 'Pendaftaran berhasil! Silakan login.';
    $_SESSION['jenis_pesan'] = 'success';

    header('Location: ../register.php');
    exit;

} catch (PDOException $e) {

    error_log($e->getMessage());

    gagalRegister('Terjadi kesalahan pada database. Silakan coba kembali.');

}
