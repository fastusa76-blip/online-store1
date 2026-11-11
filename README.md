# Hammad Online Store

Bilingual Urdu/English multi-vendor marketplace for Pakistan.
- PHP 8.1+, MySQL/MariaDB, HTML, CSS and JavaScript
- Currency: PKR (₨); Urdu RTL and English LTR
- Shared PHP hosting target; no paid theme, plugin or mandatory paid API

## Current status — do not treat as a complete store yet

The current branch is a foundation / registration prototype. It includes the responsive demo storefront, bilingual resources, database schema, customer/seller registration, login, pending approval, admin approval routes, one-time activation tokens, and manual WhatsApp click-to-chat.

The following are **not implemented as working store features yet**: database-backed product/catalog management, real search/filtering, persistent cart, checkout, order placement and tracking, seller dashboard/product management, payment verification, commissions/payouts, shipping/returns, and reviews. Product cards are illustrative demo data. Cart buttons are demo-only.

## Google Sign-in — preserve for later

Google Sign-in is **not implemented or active in this foundation**, but it is intentionally retained as a planned optional feature. Do not delete or remove its future integration point. It can be enabled later after the owner creates a Google Cloud OAuth Client ID and the redirect URI is configured. No Google credentials belong in Git.

## Local preview

From the repository directory run: `php -S 127.0.0.1:8000`
Open `/ur/` or `/en/`. PHP's built-in server is for local development only.

## Database

Import `database/schema.sql` into a new MySQL database. Copy `config/database.example.php` to `config/database.local.php` on the server and set credentials. Never commit real credentials. See [InfinityFree deployment guide](DEPLOYMENT_INFINITYFREE_UR.md).

## Product imagery and brand assets

The current prototype uses original SVG placeholders, not downloaded brand photography. Actual product images must be supplied by the seller or manufacturer with permission and accurately represent the listed item. Brand names in the demo catalog are illustrative labels, not verified inventory or offers.

## Registration and approval foundation

1. Import the updated `database/schema.sql` into a new MySQL database. If an older schema was already imported, back it up and apply a reviewed migration; do not blindly re-import over live data.
2. Copy `config/database.example.php` to `config/database.local.php` and enter the database credentials.
3. The first-admin helper `scripts/create-admin.php` is CLI-only. Many free shared hosts do not provide PHP CLI/SSH, so verify host support before relying on it. Never expose the script as a public web page.
4. New customer/seller accounts are created as `pending`; pending users cannot sign in.
5. An administrator can approve/reject applications. Approval creates a one-use activation URL valid for 72 hours. The admin must review and manually send the WhatsApp click-to-chat message.
6. Use HTTPS. Activation links are sensitive and must never be shared publicly.

## Validation status

PHP syntax lint has passed in GitHub Actions for the current foundation commit. This is not a database integration test or browser test. Before public launch, test on the actual host with a fresh database and verify all routes, registration, login, approval, activation, session security, and file permissions.

## Planned next phases

Database-backed catalog and category filters; persistent cart and checkout; multi-seller orders; seller center; full admin panel; payment verification; commissions and payouts; shipping, returns and reviews; Google OAuth; security and deployment tests.
