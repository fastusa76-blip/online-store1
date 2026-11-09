<?php
declare(strict_types=1);

/**
 * Returns a PDO connection or null when local database configuration is absent.
 * Keep database.local.php outside version control.
 */
$local = __DIR__ . '/database.local.php';
if (!is_file($local)) {
    return null;
}
$settings = require $local;
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $settings['host'], $settings['database']);
try {
    return new PDO($dsn, $settings['username'], $settings['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    error_log('Hammad Online Store database connection failed: ' . $e->getMessage());
    return null;
}
