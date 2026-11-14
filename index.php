<?php
declare(strict_types=1);
require __DIR__.'/app/bootstrap.php';
$parts=array_values(array_filter(explode('/',trim(parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH)?:'/','/')),'strlen'));
$lang=in_array($parts[0]??'',['ur','en'],true)?$parts[0]:'ur';$page=$parts[1]??'home';$t=require __DIR__."/resources/lang/{$lang}.php";$rtl=$lang==='ur';
function h(string $s):string{return htmlspecialchars($s,ENT_QUOTES,'UTF-8');}
function ru(string $l,string $p='home'):string{return '/'.$l.($p==='home'?'/':'/'.$p);}
function pkr(int $n):string{return '₨ '.number_format($n);}
$products=[['Samsung','Galaxy smartphone','گیلیکسی اسمارٹ فون',64999,'phone-demo.svg'],['Xiaomi','Redmi smartphone','ریڈمی اسمارٹ فون',42999,'phone-demo.svg'],['Apple','iPhone series','آئی فون سیریز',189999,'phone-demo.svg'],['Nike','Everyday sneakers','روزمرہ کے اسنیکرز',11999,'shoes-demo.svg'],['Adidas','Sport shoes','اسپورٹس جوتے',9999,'shoes-demo.svg'],['Puma','Casual shoes','کیژول جوتے',8999,'shoes-demo.svg'],['HP','Laptop series','لیپ ٹاپ سیریز',154999,'laptop-demo.svg'],['Dell','Business laptop','بزنس لیپ ٹاپ',169999,'laptop-demo.svg'],['Lenovo','IdeaPad series','آئیڈیا پیڈ سیریز',139999,'laptop-demo.svg']];
$cats=[['موبائل اور الیکٹرانکس','Mobiles & Electronics','▣'],['فیشن اور جوتے','Fashion & Shoes','◇'],['کمپیوٹرز','Computers','▤'],['گھر اور رہن سہن','Home & Living','⌂'],['خوبصورتی','Beauty','✿'],['کھیل','Sports','⚽']];
require_once APP_ROOT.'/app/Services/auth.php';
$route=implode('/', $parts);
if ($route==='ur' || $route==='en' || $route==='') $route='home';
if (in_array($route,['ur/register','en/register','register','seller/register'],true)) $route='register';
if (in_array($route,['ur/login','en/login','login'],true)) $route='login';
if (in_array($route,['ur/logout','en/logout','logout'],true)) $route='logout';
if ($route==='admin/login') $route='admin-login';
if ($route==='admin/dashboard') $route='admin-dashboard';
if ($route==='admin/action') $route='admin-action';
if ($route==='activate') $route='activate';
if (in_array($route,['ur/account','en/account','account'],true)) $route='account-dashboard';
if ($route==='admin/user-action') $route='admin-user-action';
if ($route==='admin/setup') $route='admin-setup';
function auth_page(string $title,string $body): never {
 echo '<!doctype html><html lang="ur" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#4c1d95"><link rel="icon" type="image/png" sizes="96x96" href="/public/assets/images/favicon.png"><link rel="icon" type="image/svg+xml" href="/public/assets/images/favicon.svg"><title>'.h($title).' — Hammad Online Store</title><style>body{margin:0;background:#f7f4fb;color:#241b31;font:16px Arial,sans-serif}.wrap{max-width:560px;margin:45px auto;padding:28px;background:#fff;border:1px solid #eee6f7;border-radius:18px;box-shadow:0 12px 40px #27133b10}h1{color:#5b21b6;font-size:25px}label{display:block;margin:14px 0 6px;font-weight:bold}input,select{width:100%;padding:12px;border:1px solid #ddd3ea;border-radius:9px;box-sizing:border-box;font-size:15px}button,.btn{display:inline-block;background:#6d28d9;color:white;border:0;border-radius:9px;padding:12px 18px;margin-top:16px;text-decoration:none;cursor:pointer;font-weight:bold}.muted{color:#71677d;font-size:13px;line-height:1.8}.alert{padding:12px;border-radius:9px;background:#fff3d9;margin:12px 0}.ok{background:#e7f8ed}.row{display:flex;gap:10px;flex-wrap:wrap}.row>*{flex:1}.table{width:100%;border-collapse:collapse;font-size:13px}.table td,.table th{border-bottom:1px solid #eee;padding:10px;text-align:right}.danger{background:#b42318}.ltr{direction:ltr;text-align:left}.auth-brand{display:flex;align-items:center;gap:12px;margin-bottom:24px;text-decoration:none;color:#241b31;font-weight:800}.auth-brand img{width:54px;height:54px;border-radius:15px}.auth-brand b{color:#6d28d9}.auth-brand small{display:block;color:#81778e;font-size:11px;font-weight:400}.auth-form{display:grid;gap:5px;margin-top:18px}.auth-form label{margin:12px 0 3px}.auth-form input,.auth-form select{min-height:48px;background:#fff}.auth-form button{width:100%;min-height:48px;font-size:15px}.auth-switch{display:flex;flex-wrap:wrap;gap:10px;margin-top:22px;padding-top:16px;border-top:1px solid #eee6f7}.auth-switch a{font-size:13px;font-weight:700;padding:9px 12px;background:#f5f0fc;border-radius:9px;text-decoration:none}.wrap>p{line-height:1.9}.wrap .alert{line-height:1.8}a{color:#5b21b6}@media(max-width:640px){body{padding:12px}.wrap{width:100%;max-width:none;margin:12px auto;padding:18px;border-radius:14px}h1{font-size:22px}.row{display:grid;grid-template-columns:repeat(2,minmax(0,1fr))}.table{display:block;max-width:100%;overflow-x:auto;white-space:normal}.table td,.table th{padding:8px;overflow-wrap:anywhere}input,select,button,.btn{min-height:42px}button,.btn{max-width:100%}}@media(max-width:380px){.wrap{padding:14px}.row{grid-template-columns:minmax(0,1fr)}.table{font-size:12px}}</style></head><body><main class="wrap"><a class="auth-brand" href="/ur/"><img src="/public/assets/images/store-mark.svg" alt="Hammad Online Store"><span>Hammad <b>Online Store</b><small>Pakistan Marketplace</small></span></a><h1>'.h($title).'</h1>'.$body.'<div class="auth-switch"><a href="/login">Login</a><a href="/register">نیا اکاؤنٹ بنائیں</a><a href="/ur/">Store پر واپس جائیں</a></div></main></body></html>'; exit;
}
function csrf_field(): string { return '<input type="hidden" name="_csrf" value="'.h(hammad_csrf_token()).'">'; }
if ($route==='logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool)$params['secure'], (bool)$params['httponly']);
    }
    session_regenerate_id(true);
    store_flash('notice', 'آپ کامیابی سے Logout ہوگئے ہیں۔');
    store_redirect('/login');
}
if ($route==='register' && $_SERVER['REQUEST_METHOD']==='POST') {
 if(!hammad_verify_csrf($_POST['_csrf']??null)) {store_flash('error','درخواست کی تصدیق ناکام ہوئی، دوبارہ کوشش کریں۔');store_redirect('/register');}
 $name=trim((string)($_POST['name']??''));$email=strtolower(trim((string)($_POST['email']??'')));$phone=store_normalize_phone((string)($_POST['phone']??''));$password=(string)($_POST['password']??'');$role=($_POST['role']??'customer')==='seller'?'seller':'customer';
 if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||!store_valid_phone($phone)||strlen($password)<10){store_flash('error','نام، درست Gmail، پاکستانی WhatsApp نمبر (+923001234567) درج کریں۔ پاس ورڈ کم از کم 10 حروف کا ہو۔');store_redirect('/register');}
 try{$db=store_db();$q=$db->prepare('INSERT INTO users(role,name,email,phone,password_hash,status) VALUES(?,?,?,?,?,\'pending\')');$q->execute([$role,$name,$email,$phone,password_hash($password,PASSWORD_DEFAULT)]);$id=(int)$db->lastInsertId();store_log($db,null,'registration_submitted','user',$id,['role'=>$role]);store_flash('notice','آپ کی درخواست جمع ہوگئی ہے۔ Admin کی منظوری تک Login بند رہے گا۔');store_redirect('/pending');}
 catch(PDOException $e){if((string)$e->getCode()==='23000'){store_flash('error','یہ Gmail یا موبائل نمبر پہلے سے رجسٹرڈ ہے۔');store_redirect('/register');}error_log($e->getMessage());store_flash('error','اکاؤنٹ بناتے وقت مسئلہ آیا۔ Database setup چیک کریں۔');store_redirect('/register');}
}
if ($route==='register' && $_SERVER['REQUEST_METHOD']==='GET') {
 $err=store_flash('error');$body=($err?'<div class="alert">'.h($err).'</div>':'').'<p class="muted">رجسٹریشن کے بعد Admin منظوری ضروری ہے۔ منظوری سے پہلے اکاؤنٹ Login نہیں کر سکے گا۔</p><form class="auth-form" method="post">'.csrf_field().'<label>پورا نام</label><input name="name" required maxlength="120"><label>Gmail / Email</label><input class="ltr" type="email" name="email" required><label>WhatsApp موبائل نمبر</label><input class="ltr" name="phone" placeholder="+923001234567 یا 03001234567" required><label>پاس ورڈ (کم از کم 10 حروف)</label><input type="password" name="password" minlength="10" autocomplete="new-password" required><label>اکاؤنٹ کی قسم</label><select name="role"><option value="customer">Customer</option><option value="seller">Seller درخواست</option></select><button type="submit">رجسٹریشن جمع کریں</button></form><p>پہلے سے اکاؤنٹ ہے؟ <a href="/login">Login</a></p>';
 auth_page('نیا اکاؤنٹ بنائیں',$body);
}
if ($route==='pending') { $msg=store_flash('notice')??'آپ کا اکاؤنٹ Admin منظوری کے انتظار میں ہے۔';auth_page('درخواست زیرِ منظوری','<div class="alert ok">'.h($msg).'</div><p>منظوری کے بعد آپ کے WhatsApp نمبر پر Activation Link بھیجا جائے گا۔ پھر آپ اپنے Gmail یا موبائل نمبر اور بنائے ہوئے پاس ورڈ سے Login کریں گے۔</p><a href="/login">Login صفحہ</a>');}
if ($route==='login' && $_SERVER['REQUEST_METHOD']==='POST') {
 if(!hammad_verify_csrf($_POST['_csrf']??null)){store_flash('error','درخواست کی تصدیق ناکام ہوئی۔');store_redirect('/login');}
 $identifier=trim((string)($_POST['identifier']??''));$phone=store_normalize_phone($identifier);$password=(string)($_POST['password']??'');
 try{$db=store_db();$q=$db->prepare('SELECT * FROM users WHERE email=? OR phone=? LIMIT 1');$q->execute([strtolower($identifier),$phone]);$u=$q->fetch();
 if(!$u||empty($u['password_hash'])||!password_verify($password,$u['password_hash'])){store_flash('error','Gmail / موبائل یا پاس ورڈ درست نہیں۔');store_redirect('/login');}
 if($u['status']==='pending'){store_flash('error','آپ کی درخواست ابھی Admin کی منظوری کے انتظار میں ہے۔');store_redirect('/login');}
 if($u['status']!=='active'){store_flash('error','یہ اکاؤنٹ فعال نہیں ہے۔ Admin سے رابطہ کریں۔');store_redirect('/login');}
 store_login_user($u);store_log($db,(int)$u['id'],'login','user',(int)$u['id']);store_redirect($u['role']==='admin'?'/admin/dashboard':'/ur/account');
 }catch(Throwable $e){error_log($e->getMessage());store_flash('error','Login سروس دستیاب نہیں۔ Database setup چیک کریں۔');store_redirect('/login');}
}
if ($route==='login') { $err=store_flash('error');$notice=store_flash('notice');auth_page('Login',''.($err?'<div class="alert">'.h($err).'</div>':'').($notice?'<div class="alert ok">'.h($notice).'</div>':'').'<form class="auth-form" method="post">'.csrf_field().'<label>Gmail یا WhatsApp موبائل نمبر</label><input class="ltr" name="identifier" required autocomplete="username"><label>پاس ورڈ</label><input type="password" name="password" required autocomplete="current-password"><button>Login کریں</button></form><p>نیا اکاؤنٹ؟ <a href="/register">رجسٹریشن کریں</a></p>');}
if ($route==='activate') {
 $token=(string)($_GET['token']??'');if(!preg_match('/^[a-f0-9]{64}$/',$token))auth_page('Activation Link غلط ہے','<p>یہ لنک درست نہیں۔ Admin سے نیا لنک طلب کریں۔</p>');
 try{$db=store_db();$q=$db->prepare("SELECT t.id token_id,u.id user_id,u.status FROM activation_tokens t JOIN users u ON u.id=t.user_id WHERE t.token_hash=? AND t.used_at IS NULL AND t.expires_at>UTC_TIMESTAMP() AND u.status='approved' LIMIT 1");$q->execute([hash('sha256',$token)]);$r=$q->fetch();if(!$r)auth_page('لنک ختم یا استعمال ہوچکا','<p>یہ Activation Link expire یا پہلے استعمال ہوچکا ہے۔ Admin سے نیا لنک لیں۔</p>');
 $db->beginTransaction();$db->prepare("UPDATE users SET status='active' WHERE id=? AND status='approved'")->execute([$r['user_id']]);$db->prepare('UPDATE activation_tokens SET used_at=UTC_TIMESTAMP() WHERE id=?')->execute([$r['token_id']]);$db->commit();auth_page('اکاؤنٹ فعال ہوگیا','<div class="alert ok">آپ کا اکاؤنٹ کامیابی سے فعال ہوگیا۔</div><a class="btn" href="/login">اب Login کریں</a>');
 }catch(Throwable $e){if(isset($db)&&$db->inTransaction())$db->rollBack();error_log($e->getMessage());auth_page('مسئلہ','<p>Activation مکمل نہیں ہوسکی۔ Admin سے رابطہ کریں۔</p>');}
}
if ($route==='admin-setup') {
 $db=store_db();
 $adminCount=(int)$db->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
 if($adminCount>0) auth_page('Setup بند ہے','<div class="alert ok">پہلا Admin اکاؤنٹ پہلے ہی بن چکا ہے۔ سکیورٹی کے لیے یہ صفحہ بند کردیا گیا ہے۔</div><a class="btn" href="/login">Admin Login</a>');
 $secretFile=APP_ROOT.'/config/admin-setup.local.php';
 if(!is_file($secretFile)) auth_page('Admin Setup تیار نہیں','<p>Hosting کے config فولڈر میں admin-setup.local.php فائل بنائیں اور اس میں Setup Secret کا SHA-256 hash محفوظ کریں۔ تفصیل Deployment Guide میں موجود ہے۔</p>');
 $storedHash=require $secretFile;
 if(!is_string($storedHash)||!preg_match('/^[a-f0-9]{64}$/',$storedHash)) auth_page('Setup Configuration Error','<p>Setup secret hash درست نہیں۔ فائل کی configuration چیک کریں۔</p>');
 if($_SERVER['REQUEST_METHOD']==='POST'){
   if(!hammad_verify_csrf($_POST['_csrf']??null)) auth_page('Security Error','<p>درخواست کی تصدیق ناکام ہوئی۔ دوبارہ کوشش کریں۔</p>');
   $secret=(string)($_POST['setup_secret']??'');$name=trim((string)($_POST['name']??''));$email=strtolower(trim((string)($_POST['email']??'')));$password=(string)($_POST['password']??'');
   if(!hash_equals($storedHash,hash('sha256',$secret))) auth_page('Setup Secret غلط ہے','<p>درج کیا گیا secret درست نہیں۔</p>');
   if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<12) auth_page('معلومات نامکمل ہیں','<p>نام، درست Email اور کم از کم 12 حروف کا مضبوط Password درج کریں۔</p>');
   try{
     $db->beginTransaction();
     $check=(int)$db->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
     if($check>0) throw new RuntimeException('Admin account already exists.');
     $q=$db->prepare("INSERT INTO users(role,name,email,phone,password_hash,status,approved_at) VALUES('admin',?,?,NULL,?,'active',UTC_TIMESTAMP())");
     $q->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);
     $newId=(int)$db->lastInsertId();store_log($db,null,'first_admin_created','user',$newId);
     $db->commit();
     @unlink($secretFile);
     auth_page('Admin اکاؤنٹ تیار ہوگیا','<div class="alert ok">پہلا Admin اکاؤنٹ کامیابی سے بن گیا۔ اب Setup صفحہ بند ہے۔</div><a class="btn" href="/login">Admin Login کریں</a>');
   }catch(Throwable $e){
     if($db->inTransaction())$db->rollBack();
     error_log($e->getMessage());
     auth_page('Admin Setup ناکام','<p>اکاؤنٹ نہیں بن سکا۔ Email پہلے سے موجود ہو سکتی ہے یا database میں مسئلہ ہے۔</p>');
   }
 }
 $body='<p class="muted">یہ ایک بار استعمال ہونے والا Admin setup ہے۔ اکاؤنٹ بننے کے بعد یہ صفحہ خود بند ہوجائے گا۔</p><form class="auth-form" method="post">'.csrf_field().'<label>One-time Setup Secret</label><input class="ltr" type="password" name="setup_secret" required autocomplete="off"><label>Admin کا نام</label><input name="name" maxlength="120" required><label>Admin Email</label><input class="ltr" type="email" name="email" required><label>مضبوط Password (کم از کم 12 حروف)</label><input type="password" name="password" minlength="12" required autocomplete="new-password"><button type="submit">پہلا Admin بنائیں</button></form>';
 auth_page('First Admin Setup',$body);
}
if ($route==='admin-login') store_redirect('/login');
if ($route==='admin-dashboard') {
 store_require_admin();
 $db=store_db();
 $pending=(int)$db->query("SELECT COUNT(*) FROM users WHERE status='pending'")->fetchColumn();
 $active=(int)$db->query("SELECT COUNT(*) FROM users WHERE status='active' AND role<>'admin'")->fetchColumn();
 $sellers=(int)$db->query("SELECT COUNT(*) FROM users WHERE role='seller'")->fetchColumn();
 $total=(int)$db->query("SELECT COUNT(*) FROM users WHERE role<>'admin'")->fetchColumn();
 $rows=$db->query("SELECT id,name,email,phone,role,status,created_at FROM users WHERE role<>'admin' ORDER BY FIELD(status,'pending','approved','active','suspended','rejected'),created_at DESC LIMIT 100")->fetchAll();
 $flash=store_flash('notice');$link=store_flash('activation_url');$wa=store_flash('wa_url');
 $body=($flash?'<div class="alert ok">'.h($flash).'</div>':'')
 .($link?'<div class="alert"><b>Activation Link (صرف ایک مرتبہ دکھایا جاتا ہے):</b><p class="ltr">'.h($link).'</p><button type="button" data-link="'.h($link).'" onclick="navigator.clipboard.writeText(this.dataset.link)">لنک Copy کریں</button><p><a target="_blank" rel="noopener" href="'.h($wa).'">WhatsApp پر پیغام کھولیں</a></p></div>':'')
 .'<div class="row"><div class="alert"><b>کل صارفین</b><h2>'.$total.'</h2></div><div class="alert"><b>فعال صارفین</b><h2>'.$active.'</h2></div><div class="alert"><b>منظوری کے منتظر</b><h2>'.$pending.'</h2></div><div class="alert"><b>Seller اکاؤنٹس</b><h2>'.$sellers.'</h2></div></div>'
 .'<h2>صارفین کا کنٹرول پینل</h2><p class="muted">یہاں آپ رجسٹریشن، اکاؤنٹ کی حالت اور Seller/Customer کی معلومات دیکھ سکتے ہیں۔ Admin اکاؤنٹ اس فہرست میں شامل نہیں۔</p>'
 .'<div style="overflow-x:auto"><table class="table"><tr><th>ID</th><th>نام / ای میل</th><th>موبائل</th><th>قسم</th><th>حالت</th><th>عمل</th></tr>';
 foreach($rows as $r){
   $body.='<tr><td>'.(int)$r['id'].'</td><td>'.h($r['name']).'<br>'.h($r['email']).'</td><td class="ltr">'.h((string)$r['phone']).'</td><td>'.h($r['role']).'</td><td>'.h($r['status']).'</td><td>';
   if($r['status']==='pending'){
     $body.='<form method="post" action="/admin/action">'.csrf_field().'<input type="hidden" name="user_id" value="'.(int)$r['id'].'"><button name="decision" value="approve">Approve</button><button class="danger" name="decision" value="reject">Reject</button></form>';
   } elseif(in_array($r['status'],['active','suspended'],true)){
     $next=$r['status']==='active'?'suspended':'active';
     $label=$next==='suspended'?'Suspend':'Activate';
     $body.='<form method="post" action="/admin/user-action">'.csrf_field().'<input type="hidden" name="user_id" value="'.(int)$r['id'].'"><input type="hidden" name="status" value="'.$next.'"><button class="'.($next==='suspended'?'danger':'').'" name="save" value="1">'.$label.'</button></form>';
   } else {$body.='<span class="muted">کوئی عمل دستیاب نہیں</span>';}
   $body.='</td></tr>';
 }
 $body.='</table></div><p><a href="/logout">Logout</a></p>';
 auth_page('Admin Control Panel',$body);
}
if ($route==='admin-user-action' && $_SERVER['REQUEST_METHOD']==='POST') {
 store_require_admin();
 if(!hammad_verify_csrf($_POST['_csrf']??null)) auth_page('Security Error','<p>CSRF verification failed.</p>');
 $id=(int)($_POST['user_id']??0);$status=(string)($_POST['status']??'');
 if(!in_array($status,['active','suspended'],true)){store_flash('notice','درخواست درست نہیں۔');store_redirect('/admin/dashboard');}
 $db=store_db();
 $q=$db->prepare("SELECT id,role,status FROM users WHERE id=? AND role IN ('customer','seller') LIMIT 1");$q->execute([$id]);$target=$q->fetch();
 if(!$target || !in_array($target['status'],['active','suspended'],true)){store_flash('notice','صارف موجود نہیں یا اس کی حالت تبدیل نہیں کی جاسکتی۔');store_redirect('/admin/dashboard');}
 $db->prepare('UPDATE users SET status=? WHERE id=?')->execute([$status,$id]);
 store_log($db,(int)hammad_current_user()['id'],'user_status_changed','user',$id,['from'=>$target['status'],'to'=>$status]);
 store_flash('notice',$status==='suspended'?'صارف کا اکاؤنٹ Suspend کردیا گیا۔':'صارف کا اکاؤنٹ دوبارہ فعال کردیا گیا۔');
 store_redirect('/admin/dashboard');
}
if ($route==='account-dashboard') {
 $user=store_require_customer();
 $db=store_db();$q=$db->prepare('SELECT name,email,phone,role,status,created_at FROM users WHERE id=? LIMIT 1');$q->execute([$user['id']]);$profile=$q->fetch();
 if(!$profile || $profile['status']!=='active'){$_SESSION=[];session_regenerate_id(true);store_redirect('/login');}
 $joined=date('d M Y',strtotime($profile['created_at']));
 $body='<div class="alert ok">خوش آمدید، '.h($profile['name']).'! آپ کامیابی سے Login ہیں۔</div>'
 .'<h2>آپ کا اکاؤنٹ</h2><table class="table"><tr><th>نام</th><td>'.h($profile['name']).'</td></tr><tr><th>Email</th><td class="ltr">'.h($profile['email']).'</td></tr><tr><th>موبائل</th><td class="ltr">'.h((string)$profile['phone']).'</td></tr><tr><th>اکاؤنٹ کی قسم</th><td>'.h($profile['role']).'</td></tr><tr><th>حالت</th><td>'.h($profile['status']).'</td></tr><tr><th>رجسٹریشن</th><td>'.$joined.'</td></tr></table>'
 .'<p class="muted">سکیورٹی کے لیے 24 گھنٹے کی غیر فعالیت کے بعد آپ خودکار طور پر Logout ہوجائیں گے۔ Logout بٹن سے آپ فوراً سیشن ختم کرسکتے ہیں۔</p>'
 .'<div class="row"><a class="btn" href="/ur/">Store پر واپس جائیں</a><a class="btn" href="/logout">Logout</a></div>';
 auth_page('Customer Dashboard',$body);
}
if ($route==='admin-action' && $_SERVER['REQUEST_METHOD']==='POST') {
 store_require_admin();if(!hammad_verify_csrf($_POST['_csrf']??null))auth_page('Security Error','<p>CSRF verification failed.</p>');
 $db=store_db();$id=(int)($_POST['user_id']??0);$decision=(string)($_POST['decision']??'');$q=$db->prepare("SELECT id,name,phone,status FROM users WHERE id=? AND role IN ('customer','seller')");$q->execute([$id]);$u=$q->fetch();if(!$u||$u['status']!=='pending') {store_flash('notice','یہ درخواست دستیاب نہیں یا پہلے دیکھی جاچکی ہے۔');store_redirect('/admin/dashboard');}
 if($decision==='approve'){$db->prepare("UPDATE users SET approved_at=UTC_TIMESTAMP(),approved_by=?,status='approved' WHERE id=?")->execute([hammad_current_user()['id'],$id]);$token=store_issue_activation($db,$id);$url=store_activation_url($token);$message='Hammad Online Store: آپ کا اکاؤنٹ منظور ہوگیا ہے۔ اسے فعال کرنے کے لیے یہ لنک کھولیں: '.$url;$wa='https://wa.me/'.substr($u['phone'],1).'?text='.rawurlencode($message);store_log($db,(int)hammad_current_user()['id'],'account_approved','user',$id);store_flash('activation_url',$url);store_flash('wa_url',$wa);store_flash('notice','اکاؤنٹ منظور ہوگیا۔ WhatsApp پیغام کھول کر Activation Link صارف کو بھیجیں۔');}
 elseif($decision==='reject'){$db->prepare("UPDATE users SET status='rejected',approved_by=? WHERE id=?")->execute([hammad_current_user()['id'],$id]);store_log($db,(int)hammad_current_user()['id'],'account_rejected','user',$id);store_flash('notice','درخواست Reject کردی گئی۔');}
 store_redirect('/admin/dashboard');
}
?><!doctype html><html lang="<?=h($lang)?>" dir="<?=$rtl?'rtl':'ltr'?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><?php $seoBase='https://hammadonlinestor.xo.je'; $seoPath=$lang==='en'?'/en/':'/ur/'; $seoUrl=$seoBase.$seoPath; ?><meta name="description" content="<?=h($t['meta'])?>"><meta name="robots" content="index,follow,max-image-preview:large"><meta name="theme-color" content="#4c1d95"><link rel="canonical" href="<?=h($seoUrl)?>"><link rel="alternate" hreflang="ur-PK" href="<?=$seoBase?>/ur/"><link rel="alternate" hreflang="en" href="<?=$seoBase?>/en/"><link rel="alternate" hreflang="x-default" href="<?=$seoBase?>/ur/"><meta property="og:type" content="website"><meta property="og:site_name" content="Hammad Online Store"><meta property="og:url" content="<?=h($seoUrl)?>"><meta property="og:title" content="Hammad Online Store — <?=h($t['tagline'])?>"><meta property="og:description" content="<?=h($t['meta'])?>"><meta property="og:image" content="<?=$seoBase?>/public/assets/images/store-mark.svg"><link rel="icon" type="image/svg+xml" href="/public/assets/images/favicon.svg"><title>Hammad Online Store — <?=h($t['tagline'])?></title><script type="application/ld+json"><?=json_encode(['@context'=>'https://schema.org','@type'=>'OnlineStore','name'=>'Hammad Online Store','url'=>$seoBase,'logo'=>$seoBase.'/public/assets/images/store-mark.svg','currenciesAccepted'=>'PKR','availableLanguage'=>['Urdu','English']],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT)?></script><link rel="stylesheet" href="/public/assets/css/app.css"><script defer src="/public/assets/js/app.js"></script></head><body>
<div class="top"><div class="container topin"><span>♧ 24/7 Customer Support</span><span>🚚 Free Delivery Across Pakistan</span><span>✓ Secure &amp; Trusted</span><span>🌐 <a href="/en/">English</a> | <a href="/ur/">اردو</a></span><span><a href="/ur/account">♙ My Account</a></span></div></div>
<header class="container header"><a class="brand" href="<?=ru($lang)?>"><img class="brand-mark" src="/public/assets/images/brand/hammad-online-store-logo.jpg" alt="Hammad Online Store"><span><strong>Hammad</strong> <b>Online Store</b><small>Shop Smart · Live Better</small></span></a><form class="search" action="<?=ru($lang,'products')?>"><input name="q" placeholder="Search for products..."><button aria-label="Search">⌕</button></form><nav><a href="<?=ru($lang,'wishlist')?>">♡ Wishlist</a><a href="<?=ru($lang,'cart')?>">🛒 Cart</a><?php if(hammad_current_user()):?><a class="account-pill" href="<?=hammad_current_user()['role']==='admin'?'/admin/dashboard':'/ur/account'?>">My Account</a><a href="/logout">Logout</a><?php else:?><a class="account-pill" href="/login">Login / Register</a><?php endif;?><a class="lang" href="<?=ru($lang==='ur'?'en':'ur',$page)?>"><?=$lang==='ur'?'English':'اردو'?></a></nav></header>
<div class="nav"><div class="container navin"><a class="nav-category" href="<?=ru($lang,'categories')?>">☰ All Categories⌄</a><a class="active" href="<?=ru($lang)?>">⌂ Home</a><a href="<?=ru($lang,'products')?>">▦ Products⌄</a><a href="<?=ru($lang,'products')?>?sale=1">◆ Deals</a><a href="/seller/register">▣ Sellers</a><a href="<?=ru($lang,'about')?>">✚ About Us</a><a href="<?=ru($lang,'contact')?>">✉ Contact Us</a><a class="whatsapp-link" href="https://wa.me/" target="_blank" rel="noopener">● Chat on WhatsApp</a></div></div><main>
<?php if($page==='home'||$page===''):?>
<section class="container hero hero-store"><div class="hero-copy"><small>WELCOME TO</small><h1>Hammad <em>Online Store</em></h1><h2>Shop Smart · Live Better</h2><p>Pakistan’s Trusted Online Marketplace for Quality Products at Best Prices.</p><div class="hero-benefits"><span>🛡️<b>Secure<br>Payments</b></span><span>🚚<b>Fast<br>Delivery</b></span><span>🎧<b>24/7<br>Support</b></span></div><a class="btn" href="<?=ru($lang,'products')?>">🛒 Start Shopping →</a><div class="home-account-links"><a href="/register">Login / Register</a><a href="/login">My Account</a></div></div><div class="hero-founder"><div class="hero-orbit"></div><img src="/public/assets/images/brand/hammad-founder-photo.jpg" alt="Hammad, founder of Hammad Online Store"><div class="hero-slogan">Smart Shopping<br>with Hammad<br><strong>Online Store</strong></div></div></section>
<section class="container section category-section"><div class="cats"><?php $visualCats=[['📱','Mobiles'],['💻','Laptops'],['🎧','Headphones'],['⌚','Smart Watches'],['🏠','Home Appliances'],['🧥','Fashion'],['🧴','Beauty & Care'],['🧸','Toys'],['⚽','Sports'],['▦','View All']]; foreach($visualCats as $i=>$vc):?><a class="cat visual-cat c<?=$i%6?>" href="<?=ru($lang,'products')?>"><i><?=$vc[0]?></i><b><?=$vc[1]?></b></a><?php endforeach;?></div></section>
<section class="container promo-row"><a class="promo promo-blue" href="<?=ru($lang,'products')?>?sale=1"><span>🛒</span><b>Big Discounts<br>Up to 50% OFF</b><small>Shop Now →</small><i>🎁</i></a><a class="promo promo-green" href="<?=ru($lang,'products')?>"><span>🚚</span><b>Free Delivery<br><small>All Over Pakistan</small></b><small>Order Now →</small><i>🇵🇰</i></a><a class="promo promo-pink" href="<?=ru($lang,'products')?>?sale=1"><span>🏷️</span><b>Special Offer<br><small>Don’t Miss Out!</small></b><small>Grab Now →</small><i>🎁</i></a></section>
<section class="section muted"><div class="container"><div class="heading"><div><small><?=$t['selected']?></small><h2><?=$t['featured']?></h2></div><a href="<?=ru($lang,'products')?>"><?=$t['all']?> →</a></div><div class="grid"><?php foreach($products as $p):?><article class="card"><div class="photo"><img src="/public/assets/images/<?=h($p[4])?>" alt="<?=h($p[0])?>" loading="lazy"><span><?=$t['sample']?></span></div><div class="info"><small><?=h($p[0])?></small><h3><?=h($rtl?$p[2]:$p[1])?></h3><strong><?=pkr($p[3])?></strong><button data-demo-cart><?=$t['add']?></button></div></article><?php endforeach;?></div></div></section>
<section class="container seller-cta"><div><small><?=$t['grow']?></small><h2><?=$t['sellerTitle']?></h2><p><?=$t['sellerText']?></p><a class="btn" href="/seller/register"><?=$t['start']?></a></div><b>↗</b></section>
<?php elseif(in_array($page,['products','categories'],true)):?><section class="container section"><div class="heading"><h1><?=$t['products']?></h1></div><div class="grid"><?php foreach($products as $p):?><article class="card"><div class="photo"><img src="/public/assets/images/product-placeholder.svg" alt="<?=h($p[0])?>"></div><div class="info"><small><?=h($p[0])?></small><h3><?=h($rtl?$p[2]:$p[1])?></h3><strong><?=pkr($p[3])?></strong><button data-demo-cart><?=$t['add']?></button></div></article><?php endforeach;?></div></section><?php else:?><section class="container empty"><h1><?=$t['soon']?></h1><p><?=$t['soonText']?></p><a class="btn" href="<?=ru($lang)?>"><?=$t['home']?></a></section><?php endif;?></main>
<footer><div class="container foot"><div><b>Hammad Online Store</b><p><?=$t['foot']?></p></div><div><b><?=$t['service']?></b><a href="<?=ru($lang,'contact')?>"><?=$t['contact']?></a><a href="<?=ru($lang,'returns')?>"><?=$t['returns']?></a></div><div><b><?=$t['market']?></b><a href="/seller/register"><?=$t['seller']?></a><a href="/admin/login"><?=$t['admin']?></a></div><div><b><?=$t['payment']?></b><p>COD · Bank Transfer · Easypaisa · JazzCash</p></div></div><div class="container copyright">© <?=date('Y')?> Hammad Online Store · <?=$t['rights']?></div></footer><div id="toast" class="toast" role="status"></div></body></html>