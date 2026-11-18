
<?php

require_once __DIR__ . '/../config/auth.php';

// Memastikan permintaan berasal dari formulir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

// Mengambil data dari formulir
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Fungsi untuk mengembalikan pesan kesalahan
function gagalLogin($pesan)
{
    $_SESSION['pesan_login'] = $pesan;

    header('Location: ../login.php');
    exit;
}

// Validasi input
if ($email === '' || $password === '') {
    gagalLogin('Email dan password wajib diisi.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    gagalLogin('Format email tidak valid.');
}

try {

    // Mencari pengguna berdasarkan email
    $query = "SELECT
                id_pengguna,
                nama,
                email,
                password,
                peran,
                status_akun
              FROM pengguna
              WHERE email = :email
              LIMIT 1";

    $stmt = $pdo->prepare($query);

    $stmt->execute([
        ':email' => $email
    ]);

    $pengguna = $stmt->fetch();

    // Memeriksa email dan password
    if (!$pengguna || !password_verify($password, $pengguna['password'])) {
        gagalLogin('Email atau password salah.');
    }

    // Memeriksa status akun
    if ($pengguna['status_akun'] !== 'aktif') {
        gagalLogin('Akun Anda sedang dinonaktifkan.');
    }

    // Mengganti session ID untuk keamanan
    session_regenerate_id(true);

    // Menyimpan identitas pengguna ke session
    $_SESSION['pengguna'] = [
        'id_pengguna' => $pengguna['id_pengguna'],
        'nama' => $pengguna['nama'],
        'email' => $pengguna['email'],
        'peran' => $pengguna['peran'],
        'status_akun' => $pengguna['status_akun']
    ];

    // Mengarahkan pengguna berdasarkan peran
    if ($pengguna['peran'] === 'penyewa') {

        header('Location: ../penyewa/dashboard.php');

    } elseif (
        $pengguna['peran'] === 'admin' ||
        $pengguna['peran'] === 'superadmin'
    ) {

        header('Location: ../admin/dashboard.php');

    } else {

        $_SESSION = [];
        session_destroy();

        header('Location: ../login.php');
    }

    exit;

} catch (PDOException $e) {

    error_log($e->getMessage());

    gagalLogin('Terjadi kesalahan pada database. Silakan coba kembali.');

}