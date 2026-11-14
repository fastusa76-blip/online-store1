<?php
declare(strict_types=1);

// Keep authenticated sessions for up to 24 hours. The timestamp check below
// enforces the idle timeout even when the host's session garbage collector varies.
ini_set('session.gc_maxlifetime', '86400');
ini_set('session.cookie_lifetime', '86400');

$secureCookie = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('hammad_store');
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure' => $secureCookie,
        'use_strict_mode' => true,
    ]);
}

date_default_timezone_set('Asia/Karachi');

$sessionNow = time();
if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    $lastActivity = (int)($_SESSION['last_activity'] ?? 0);
    if ($lastActivity > 0 && ($sessionNow - $lastActivity) >= 86400) {
        $_SESSION = [];
        session_regenerate_id(true);
        $_SESSION['_flash']['notice'] = 'سکیورٹی کی خاطر آپ کا سیشن 24 گھنٹے کی غیر فعالیت کے بعد ختم ہوگیا۔ دوبارہ Login کریں۔';
    } else {
        $_SESSION['last_activity'] = $sessionNow;
        // Refresh the cookie expiry on activity; server-side idle timeout remains authoritative.
        setcookie(session_name(), session_id(), [
            'expires' => $sessionNow + 86400,
            'path' => '/',
            'secure' => $secureCookie,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}

define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/app/Helpers/security.php';
