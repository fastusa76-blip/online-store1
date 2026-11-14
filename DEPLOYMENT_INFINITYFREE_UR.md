# InfinityFree پر Hammad Online Store اپ لوڈ اور ابتدائی ٹیسٹنگ

> یہ رہنمائی موجودہ foundation/registration ورژن کے لیے ہے۔ یہ مکمل خرید و فروخت والا marketplace نہیں ہے۔ اصل orders یا payments لینے کے لیے checkout، order management اور payment verification پہلے مکمل کرنا ضروری ہے۔

## 1) درست GitHub برانچ حاصل کریں

- Repository: https://github.com/fastusa76-blip/online-store1
- Branch: `feature/phase-1-foundation`
- Pull Request #1 ابھی draft/open ہے؛ اسے merged یا production-ready نہ سمجھیں۔
- GitHub سے اسی برانچ کا ZIP حاصل کریں۔ `main` برانچ کے بجائے feature branch استعمال کریں۔

## 2) فائلیں کہاں اپ لوڈ کرنی ہیں

ZIP extract کریں۔ اس کے اندر موجود project files اپنے hosting account کے web root (اکثر `htdocs`) میں اپ لوڈ کریں۔ web root کے اندر براہِ راست `index.php` اور `.htaccess` نظر آنے چاہئیں؛ ایسا نہ ہو کہ ایک اضافی nested folder بن جائے۔

یہ چیزیں بھی اپ لوڈ ہوں:
- `app/`
- `config/`
- `database/`
- `public/`
- `resources/`
- `scripts/`
- `index.php`
- `.htaccess`

Hidden file `.htaccess` بھی اپ لوڈ کریں۔ `config/database.local.php` GitHub ZIP میں موجود نہیں ہونی چاہیے؛ اسے hosting پر خود بنانا ہے۔

## 3) PHP ورژن اور ضروری extensions

Hosting control panel میں PHP version کم از کم 8.1 رکھیں، بہتر ہے 8.2 اگر دستیاب ہو۔ PDO اور PDO MySQL extension فعال ہونے چاہئیں۔ اگر یہ extensions دستیاب نہ ہوں تو database connection نہیں چلے گا۔

## 4) MySQL database بنائیں

1. Hosting control panel میں MySQL Databases کھولیں۔
2. نیا database اور database user بنائیں۔
3. Hostname، database name، username اور password محفوظ نوٹ کریں۔
4. phpMyAdmin کھولیں، اپنا نیا database منتخب کریں۔
5. `database/schema.sql` فائل Import کریں۔
6. Import مکمل ہونے پر `users`, `products`, `orders` وغیرہ tables نظر آنے چاہئیں۔

**اہم:** یہ schema نئے خالی database کے لیے ہے۔ موجودہ data والے database پر بغیر backup کے دوبارہ import نہ کریں۔

## 5) database.local.php بنائیں

Hosting File Manager میں `config` folder کھولیں۔ `database.example.php` کی copy بنا کر اس کا نام `database.local.php` رکھیں۔ اس فائل میں hosting کے اصل database credentials درج کریں:

```php
<?php
return [
    'host' => 'YOUR_HOSTNAME',
    'database' => 'YOUR_DATABASE_NAME',
    'username' => 'YOUR_DATABASE_USERNAME',
    'password' => 'YOUR_DATABASE_PASSWORD',
];
```

یہ صرف نمونہ ہے۔ اصل credentials اپنی hosting سے لیں۔ یہ فائل کسی کو نہ بھیجیں اور GitHub پر upload نہ کریں۔

## 6) ابتدائی Admin اکاؤنٹ — موجودہ رکاوٹ

موجودہ `scripts/create-admin.php` صرف PHP CLI سے چلتا ہے۔ Free shared hosting پر SSH/PHP CLI دستیاب نہ بھی ہو۔ اس لیے پہلے control panel میں دیکھیں کہ SSH/CLI دستیاب ہے یا نہیں۔ اگر نہیں، تو Admin بنانے کا محفوظ متبادل (مثلاً محدود مدت کا one-time setup طریقہ) کوڈ میں شامل کیے بغیر public site پر Admin dashboard استعمال نہیں ہو سکے گا۔

**کبھی بھی** `create-admin.php` کو browser سے چلانے کے لیے اس کی CLI protection نہ ہٹائیں، اور نہ ہی کوئی مستقل public admin-creation URL کھلا چھوڑیں۔

## 7) Login، Dashboard اور 24 گھنٹے کا سیشن

- صارف `/register` سے رجسٹریشن کرے گا؛ نئی درخواست Admin کی منظوری تک pending رہے گی۔
- منظوری اور activation کے بعد صارف `/login` سے Email یا پاکستانی موبائل نمبر اور Password کے ذریعے داخل ہوگا۔
- Customer Dashboard: `/ur/account`۔ Admin Control Panel: `/admin/dashboard`۔
- Login سیشن زیادہ سے زیادہ 24 گھنٹے چلے گا؛ 24 گھنٹے کی غیر فعالیت پر بھی ختم ہوگا۔ Logout بٹن فوراً سیشن ختم کرتا ہے۔
- Admin pending درخواستیں منظور یا مسترد کر سکتا ہے، اور فعال Customer/Seller اکاؤنٹ Suspend یا دوبارہ فعال کر سکتا ہے۔

## 8) ابتدائی محفوظ ٹیسٹ

- Home page اردو اور English دونوں میں کھلتا ہے۔
- `/register` پر test customer بنائیں؛ status `pending` ہونا چاہیے۔
- Pending user سے login ناکام ہونا چاہیے۔
- Admin بننے کا محفوظ طریقہ دستیاب ہونے کے بعد Admin login، approval/rejection اور activation link چیک کریں۔
- Activation link ایک بار استعمال ہونے کے بعد دوبارہ کام نہیں کرنا چاہیے۔
- Mobile اور desktop دونوں پر layout دیکھیں۔
- Browser میں PHP errors یا database credentials ظاہر نہیں ہونے چاہئیں۔

## 9) ابھی کیا کام نہیں کرتا

Database میں products/orders کے tables موجود ہونے کا مطلب یہ نہیں کہ ان کے مکمل صفحات یا workflows بن چکے ہیں۔ موجودہ product cards demo data ہیں، cart demo-only ہے، اور checkout، حقیقی order placement، seller management اور payment verification ابھی مکمل نہیں۔ اس ورژن پر حقیقی customers سے ادائیگی یا live orders نہ لیں۔

## 10) اپ لوڈ سے پہلے حفاظتی فہرست

- HTTPS/SSL فعال کریں۔
- `config/database.local.php` کے credentials نجی رکھیں۔
- Debug output بند رکھیں۔
- Demo products کو حقیقی inventory نہ کہیں۔
- پہلے test accounts اور test data استعمال کریں۔
- جب تک Admin setup اور database/browser tests پاس نہ ہوں، public registration کھولنے میں احتیاط کریں۔
