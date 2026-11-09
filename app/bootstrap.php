<?php
declare(strict_types=1);
if(session_status()!==PHP_SESSION_ACTIVE){session_name('hammad_store');session_start(['cookie_httponly'=>true,'cookie_samesite'=>'Lax','use_strict_mode'=>true,'cookie_secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off']);}
date_default_timezone_set('Asia/Karachi');
define('APP_ROOT',dirname(__DIR__));
require_once APP_ROOT.'/app/Helpers/security.php';