# Hammad Online Store

Bilingual Urdu/English multi-vendor marketplace for Pakistan.
- PHP 8.1+, MySQL/MariaDB, HTML, CSS and JavaScript
- Currency: PKR (₨); Urdu RTL and English LTR
- Shared PHP hosting target; no paid theme, plugin or mandatory paid API

## Current status
Phase 1 foundation prototype: responsive storefront, language switch, sample brand-labelled catalog cards, security helpers and a custom SVG placeholder. Cart buttons are demo-only. Authentication, database-backed catalog, checkout, seller and admin workflows are not active yet.

## Local preview
From the repository directory run: php -S 127.0.0.1:8000
Open /ur/ or /en/. PHP's built-in server is for local development only.

## Database
Import database/schema.sql into MySQL. Copy config/database.example.php to config/database.local.php on the server and set credentials. Never commit real credentials.

## Product imagery and brand assets
The current prototype uses an original SVG placeholder, not downloaded brand photography. Actual product images must be supplied by the seller or manufacturer with permission and accurately represent the listed item. Brand names in the demo catalog are illustrative labels, not verified inventory or offers. Do not bulk-compile Unsplash images into a competing marketplace; its license restricts that use.

## Next phases
Authentication and roles; bilingual routing; database-backed catalog; cart and checkout; multi-seller orders; seller center; admin panel; payment verification; commissions and payouts; shipping, returns, reviews; security tests and deployment.