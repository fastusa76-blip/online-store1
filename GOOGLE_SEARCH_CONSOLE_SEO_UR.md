# Hammad Online Store — Google Search Console & SEO (Urdu)

Canonical website hostname selected by the owner:
- https://hammadonlinestor.xo.je

## Files included in this SEO foundation

- `robots.txt`: allows public crawling, disallows private account/admin/activation routes, and references the sitemap.
- `sitemap.xml`: lists only the currently implemented public Urdu and English home pages.
- `index.php`: adds language-specific canonical URLs, Urdu/English hreflang, meta description, Open Graph fields, favicon reference and basic OnlineStore JSON-LD.
- `public/assets/images/favicon.png`: 96×96 PNG favicon for Google Search compatibility.
- `public/assets/images/favicon.svg`: scalable browser favicon (temporary brand mark; replace with final approved brand artwork without changing the URLs if possible).

The sitemap is intentionally limited to public pages that currently exist. Do not add demo product URLs or account/admin pages. When real category and product pages are implemented, generate the sitemap dynamically from published database records.

## Before launch

1. Enable HTTPS/SSL for `hammadonlinestor.xo.je` in the hosting panel and confirm both `https://hammadonlinestor.xo.je/ur/` and `https://hammadonlinestor.xo.je/en/` load without certificate warnings.
2. Keep one canonical hostname and redirect HTTP to HTTPS if the hosting platform supports it. Do not add a `www` hostname unless it is actually configured.
3. Upload the project files to the exact website document root shown in InfinityFree Client Area → Accounts → your account → Domains. The first domain is often `htdocs`, but verify the directory for this domain.
4. Check these public URLs after upload:
   - `https://hammadonlinestor.xo.je/robots.txt`
   - `https://hammadonlinestor.xo.je/sitemap.xml`
   - `https://hammadonlinestor.xo.je/public/assets/images/favicon.svg`
   - `https://hammadonlinestor.xo.je/ur/`
   - `https://hammadonlinestor.xo.je/en/`

## Google Search Console setup

1. Open https://search.google.com/search-console/
2. Choose **URL prefix** property (easiest for a free subdomain): `https://hammadonlinestor.xo.je/`.
3. Use the HTML tag or HTML file verification method offered by Search Console. Add the exact verification meta tag to the homepage `<head>`, or upload the exact downloaded verification file to the website document root. Do not invent or reuse a verification token; Google generates a unique one for your property.
4. Click Verify after the website is publicly reachable over HTTPS.
5. Open **Sitemaps** and submit: `sitemap.xml`.
6. Use URL Inspection for `https://hammadonlinestor.xo.je/ur/` and `https://hammadonlinestor.xo.je/en/`; request indexing when available.
7. Review Page Indexing and Sitemaps reports for crawl or processing errors.

## Important SEO notes

- Sitemap submission is a hint, not a guarantee of indexing or ranking.
- Google may take days or weeks to recrawl the homepage and favicon.
- Search-result favicon display is not guaranteed. Google's current favicon documentation lists supported formats (BMP, GIF, ICO, PNG, JPEG, PPM, TIFF). A square 96×96 PNG has been added and linked with `rel="icon"`; the scalable SVG remains as an additional browser favicon. Google Search display is not guaranteed.
- The current face-based final logo has not yet been supplied/approved for the website asset. The present SVG is a temporary H monogram.
- Do not add a Google Analytics ID, Google OAuth Client ID, Search Console verification token, database password or other secret to public GitHub files.
- Google Sign-in is not implemented yet and remains a future optional feature.

## Database status

No database is required to verify the static homepage, robots file or initial sitemap. Create the MySQL database later, after the project files are uploaded. Then import `database/schema.sql` into the new empty database and create `config/database.local.php` on the hosting account. Never upload real database credentials to GitHub.
