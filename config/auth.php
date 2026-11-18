

<?php

require_once __DIR__ . '/database.php';

/*
|--------------------------------------------------------------------------
| Memulai Session
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {

    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax'
    ]);

    session_start();
}

/*
|--------------------------------------------------------------------------
| Mengambil Data Pengguna yang Login
|--------------------------------------------------------------------------
*/

function penggunaLogin()
{
    if (!isset($_SESSION['pengguna'])) {
        return null;
    }

    return $_SESSION['pengguna'];
}

/*
|--------------------------------------------------------------------------
| Memeriksa Status Login dan Akun
|--------------------------------------------------------------------------
*/

function wajibLogin()
{
    $pengguna = penggunaLogin();

    if (!$pengguna) {
        header('Location: ../login.php');
        exit;
    }

    try {
        global $pdo;

        $query = "SELECT id_pengguna, nama, email, peran, status_akun
                  FROM pengguna
                  WHERE id_pengguna = :id
                  LIMIT 1";

        $stmt = $pdo->prepare($query);

        $stmt->execute([
            ':id' => $pengguna['id_pengguna']
        ]);

        $data = $stmt->fetch();

        if (!$data || $data['status_akun'] !== 'aktif') {
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();

                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            session_destroy();

            header('Location: ../login.php');
            exit;
        }

        // Memperbarui data session
        $_SESSION['pengguna'] = $data;

        return $data;

    } catch (PDOException $e) {
        error_log($e->getMessage());

        http_response_code(500);
        die('Terjadi kesalahan saat memeriksa akun.');
    }
}

/*
|--------------------------------------------------------------------------
| Memeriksa Hak Akses Berdasarkan Peran
|--------------------------------------------------------------------------
*/

function wajibPeran(...$peranDiizinkan)
{
    $pengguna = wajibLogin();

    if (!in_array($pengguna['peran'], $peranDiizinkan, true)) {
        http_response_code(403);
        die('Akses ditolak. Anda tidak memiliki izin.');
    }

    return $pengguna;
}

/*
|--------------------------------------------------------------------------
| Mengarahkan Pengguna Sesuai Peran
|--------------------------------------------------------------------------
*/

function arahkanSesuaiPeran($peran)
{
    switch ($peran) {

        case 'penyewa':
            header('Location: penyewa/dashboard.php');
            break;

        case 'admin':
        case 'superadmin':
            header('Location: admin/dashboard.php');
            break;

        default:
            header('Location: login.php');
            break;
    }

    exit;
}
