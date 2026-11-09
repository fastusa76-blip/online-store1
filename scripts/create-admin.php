<?php
declare(strict_types=1);
// Run only from CLI: php scripts/create-admin.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__).'/app/bootstrap.php';
require APP_ROOT.'/app/Services/auth.php';
if ($argc < 4) { fwrite(STDERR, "Usage: php scripts/create-admin.php \"Admin Name\" admin@example.com \"StrongPassword\"\n"); exit(1); }
$name=trim($argv[1]); $email=strtolower(trim($argv[2])); $password=$argv[3];
if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($password)<12) { fwrite(STDERR,"Name/email invalid; password must be at least 12 characters.\n"); exit(1); }
$db=store_db();
$stmt=$db->prepare("INSERT INTO users(role,name,email,phone,password_hash,status,approved_at) VALUES('admin',?,?,NULL,?,'active',UTC_TIMESTAMP())");
$stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);
echo "Admin account created. Delete this script after use.\n";
