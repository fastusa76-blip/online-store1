<?php
declare(strict_types=1);
function hammad_csrf_token():string{if(empty($_SESSION['_csrf']))$_SESSION['_csrf']=bin2hex(random_bytes(32));return $_SESSION['_csrf'];}
function hammad_verify_csrf(?string $token):bool{return is_string($token)&&isset($_SESSION['_csrf'])&&hash_equals($_SESSION['_csrf'],$token);}
function hammad_current_user():?array{return isset($_SESSION['user'])&&is_array($_SESSION['user'])?$_SESSION['user']:null;}
function hammad_require_role(array $roles):void{$u=hammad_current_user();if(!$u||!in_array($u['role']??'',$roles,true)){http_response_code(403);exit('Access denied');}}