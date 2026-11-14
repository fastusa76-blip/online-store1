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

## 2-A) منتخب Domain اور SEO فائلیں

منتخب ویب سائٹ URL: `https://hammadonlinestor.xo.je`

SEO کی ابتدائی فائلیں بھی ویب روٹ میں اپلوڈ کریں:
- `robots.txt`
- `sitemap.xml`
- `public/assets/images/favicon.svg`

یہ فائلیں موجودہ اردو اور انگریزی ہوم پیجز کے لیے canonical URLs، hreflang، Open Graph اور OnlineStore JSON-LD شامل کرتی ہیں۔ Sitemap فی الحال صرف `/ur/` اور `/en/` کو شامل کرتا ہے کیونکہ حقیقی database-backed product/category pages ابھی تیار نہیں۔ جب اصل catalog مکمل ہوگا تو sitemap کو database سے خودکار بنائیں گے۔

Google Search Console میں URL-prefix property `https://hammadonlinestor.xo.je/` شامل کریں۔ Google کی طرف سے ملنے والا اصل HTML verification tag یا فائل ہی استعمال کریں؛ کوئی فرضی token نہ بنائیں۔ پھر `sitemap.xml` submit کریں۔ مکمل رہنمائی `GOOGLE_SEARCH_CONSOLE_SEO_UR.md` میں ہے۔

HTTPS/SSL فعال ہونے اور بغیر certificate warning کے کام کرنے کی تصدیق کے بعد ہی HTTPS canonical URLs استعمال کریں۔ Search Console میں favicon دکھنے کی ضمانت نہیں ہوتی؛ Google کی موجودہ دستاویزات PNG/ICO سمیت مخصوص formats بتاتی ہیں، اس لیے حتمی لوگو کے ساتھ 48×48 یا اس سے بڑا PNG/ICO بھی شامل کرنا باقی ہے۔

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

## 6) پہلا Admin اکاؤنٹ بنائیں — One-time setup

اب shared hosting کے لیے محدود اور ایک بار استعمال ہونے والا setup راستہ شامل ہے:

1. Hosting File Manager میں `config/admin-setup.example.php` کی copy بنائیں۔
2. copy کا نام `admin-setup.local.php` رکھیں۔
3. فائل میں placeholder کی جگہ اپنا نیا، خفیہ random secret (کم از کم 32 حروف) لکھیں۔ مثال کے طور پر فائل کا آخری حصہ یوں ہوگا:
   `return hash('sha256', 'یہاں اپنا نیا لمبا اور خفیہ secret لکھیں');`
4. اسی secret کو نجی رکھیں؛ GitHub یا کسی شخص کو نہ بھیجیں۔
5. براؤزر میں اپنی ویب سائٹ کا `/admin/setup` صفحہ کھولیں۔ Secret، Admin نام، Email اور کم از کم 12 حروف کا مضبوط Password درج کریں۔
6. کامیابی کے بعد setup فائل خود حذف کرنے کی کوشش ہوگی، اور ڈیٹابیس میں Admin پہلے سے موجود ہونے کی وجہ سے setup صفحہ دوبارہ کام نہیں کرے گا۔
7. پھر `/login` پر Admin Email اور Password سے Login کریں۔ Admin Control Panel `/admin/dashboard` پر ہے۔

اگر ہوسٹنگ فائل حذف کرنے کی اجازت نہ دے تو بھی database میں Admin موجود ہونے کی وجہ سے setup route بند رہے گا؛ پھر بھی File Manager سے `admin-setup.local.php` خود حذف کردیں۔

**اہم:** `admin-setup.local.php` کبھی GitHub پر upload نہ کریں۔ `scripts/create-admin.php` کی CLI protection بھی نہ ہٹائیں اور کوئی مستقل public admin-creation URL نہ بنائیں۔

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
