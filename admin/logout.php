<?php
session_start();

// Hapus semua data sesi
$_SESSION = [];

// Hapus session cookie juga (opsional, untuk keamanan ekstra)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hapus juga cookie 'remember me' jika ada
setcookie('username', '', time() - 3600, "/");

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
header("Location: ../login.php");
exit;
?>
