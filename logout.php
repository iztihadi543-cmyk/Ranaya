
<?php

require_once __DIR__ . '/config/auth.php';

// Menghapus seluruh data session
$_SESSION = [];

// Menghapus cookie session dari browser
if (ini_get('session.use_cookies')) {
    $parameter = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $parameter['path'],
        $parameter['domain'],
        $parameter['secure'],
        $parameter['httponly']
    );
}

// Mengakhiri session
session_destroy();

// Kembali ke halaman login
header('Location: login.php');
exit;