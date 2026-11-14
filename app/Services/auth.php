<?php
declare(strict_types=1);

function store_db(): PDO {
    static $db = null;
    if ($db instanceof PDO) return $db;
    $db = require APP_ROOT . '/config/database.php';
    if (!$db instanceof PDO) throw new RuntimeException('Database is not configured. Import database/schema.sql and create config/database.local.php.');
    return $db;
}
function store_redirect(string $path): never { header('Location: '.$path, true, 303); exit; }
function store_flash(string $key, ?string $value = null): ?string {
    if ($value !== null) { $_SESSION['_flash'][$key] = $value; return null; }
    $message = $_SESSION['_flash'][$key] ?? null; unset($_SESSION['_flash'][$key]); return is_string($message) ? $message : null;
}
function store_normalize_phone(string $phone): string {
    $phone = preg_replace('/[\\s()\\-]/', '', trim($phone)) ?? '';
    if (str_starts_with($phone, '03') && strlen($phone) === 11) $phone = '+92'.substr($phone, 1);
    elseif (str_starts_with($phone, '92') && !str_starts_with($phone, '+')) $phone = '+'.$phone;
    return $phone;
}
function store_valid_phone(string $phone): bool { return (bool)preg_match('/^\\+92[0-9]{10}$/', $phone); }
function store_issue_activation(PDO $db, int $userId): string {
    $token = bin2hex(random_bytes(32));
    $db->prepare('INSERT INTO activation_tokens(user_id,token_hash,expires_at) VALUES(?,?,DATE_ADD(UTC_TIMESTAMP(), INTERVAL 72 HOUR))')
       ->execute([$userId, hash('sha256',$token)]);
    return $token;
}
function store_activation_url(string $token): string {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $base = ($https ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    return $base.'/activate?token='.rawurlencode($token);
}
function store_log(PDO $db, ?int $actor, string $action, string $type, ?int $id, array $details=[]): void {
    $db->prepare('INSERT INTO audit_logs(actor_user_id,action,entity_type,entity_id,details,ip_address) VALUES(?,?,?,?,?,?)')
       ->execute([$actor,$action,$type,$id,json_encode($details,JSON_UNESCAPED_UNICODE),$_SERVER['REMOTE_ADDR'] ?? null]);
}
function store_login_user(array $user): void {
    session_regenerate_id(true);
    unset($_SESSION['_csrf']);
    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'role' => $user['role'],
    ];
    $_SESSION['last_activity'] = time();
    $_SESSION['auth_started_at'] = time();
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    setcookie(session_name(), session_id(), [
        'expires' => time() + 86400,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}
function store_require_admin(): void {
    $user = hammad_current_user();
    if (!$user || ($user['role'] ?? '') !== 'admin') {
        http_response_code($user ? 403 : 401);
        exit('صرف Admin کو اجازت ہے۔ پہلے Admin اکاؤنٹ سے Login کریں۔');
    }
}
function store_require_customer(): array {
    $user = hammad_current_user();
    if (!$user) store_redirect('/login');
    if (($user['role'] ?? '') === 'admin') store_redirect('/admin/dashboard');
    return $user;
}
