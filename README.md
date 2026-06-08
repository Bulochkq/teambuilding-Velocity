# Velocity Cyklo Teambuilding Website

A high-performance, premium single-page landing website for **Velocity Bratislava**, offering corporate cycling and e-bike teambuilding events.

---

## 🚀 Project Overview

The website is designed with a modern aesthetic, utilizing rich typography, custom smooth scroll/reveal animations, glassmorphism cards, and an interactive layout. It serves to showcase teambuilding packages, benefits of cycling events, options for teams, and features a direct contact form to request custom offers.

---

## 📂 File Structure & Explanations

Here is a breakdown of the repository files and their roles:

### 1. [`index.html`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/index.html)
The primary landing page.
- **Design & Styling**: Utilizes **Tailwind CSS** (via CDN) with a custom configuration extension (brand colors, Outfit and Inter fonts). Features manual custom CSS for:
  - Custom glassmorphism classes (`.glass` and `.glass-dark`).
  - Organic glowing background shapes (`.organic-blob-1`, `.organic-blob-2`) and floating badge animations.
  - Interactive hover highlights and active states.
  - Dark-mode input color schemes to prevent cursor bugs in Chrome/Safari.
- **Interactive UI Logic (Vanilla JS)**:
  - **Dynamic Navbar**: Features a sliding background highlight indicator that moves smoothly under active menu items, and a scroll-fade helper arrow for small/mobile screens.
  - **Pricing Slider**: A custom swipe/scroll carousel for pricing cards with next/prev pagination buttons, swipe logic, and auto-centering resize listeners.
  - **Contact Form Validation & AJAX**: Captures the inputs (`Name`, `Company`, `Email`, `Phone`, `Number of People`, `Preferred Date`, `Notes`, `GDPR approval`), performs immediate validation, and sends the payload asynchronously via AJAX to the PHP backend.
- **SEO & Metadata**: Implements SEO best practices including schema-structured metadata (`application/ld+json`), canonical links, OpenGraph headers, Twitter cards, and responsive viewport options.

### 2. [`send.php`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/send.php)
The server-side contact form handler written in PHP.
- **Validation**: Cleans and validates inputs, sanitizes headers to prevent email injection attacks.
- **Dual Mode Support**:
  - **AJAX Requests**: Detects AJAX queries and responds with plain-text status codes (`success`, `error_missing_fields`, `error`).
  - **Standard POST Fallback**: Redirects with URL search parameters (e.g., `?status=success#kontakt`) in case Javascript is disabled.
- **Mail Setup**: Sends HTML-compliant plain text emails to `bulochkq@gmail.com` using the native PHP `mail()` function, setting appropriate `From` and `Reply-To` headers.

### 3. [`.htaccess`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/.htaccess)
Apache configuration file for performance and routing optimization.
- **HTTPS Enforcement**: Pre-configured rules to redirect HTTP requests to HTTPS (commented out by default, ready to activate on production).
- **Custom Error Handling**: Maps all 404 errors to the custom error page (`/404.html`).
- **GZIP Compression**: Compresses HTML, XML, CSS, JS, and plain text using `mod_deflate` to reduce bundle transfer size.
- **Browser Caching**: Optimizes site speed with `mod_expires` caching policies, specifying long cache lifetimes for assets (images, webp, fonts) and forcing re-validation for HTML pages.

### 4. [`404.html`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/404.html)
A custom, styled 404 error page. Matches the landing page design with Outfit/Inter typography, animated glowing background gradients, and a glassmorphism error card.

### 5. [`robots.txt`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/robots.txt)
Instructs search engines to index all pages and references the XML sitemap location.

### 6. [`sitemap.xml`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/sitemap.xml)
XML sitemap specifying indexable canonical pages (`https://teambuilding.velocity.sk/`) and crawl frequencies.

---

## 🛠️ Tech Stack & Dependencies

- **Frontend markup**: HTML5
- **Styling framework**: Tailwind CSS (CDN implementation) + Vanilla CSS utilities
- **Typography**: Outfit & Inter (sourced via Google Fonts)
- **Logic**: Vanilla Javascript (ES6+)
- **Server backend**: PHP 7.x/8.x
- **Server configuration**: Apache `.htaccess`

---

## ⚙️ Configuration & Deployment

### 📧 Changing the Recipient Email
To direct client requests to a different email address, open [`send.php`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/send.php) and change the `$to` variable on line 34:
```php
$to = "your-email@example.com";
```

### 🔒 Enforcing HTTPS
Once the site is hosted on a live server with an SSL certificate, uncomment lines 2–4 in [`.htaccess`](file:///c:/Users/buloc/OneDrive/Рабочий стол/teambuilding/.htaccess) to redirect all traffic to secure HTTPS:
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 🖼️ Adding Custom Photos
The page utilizes placeholders and static references to the `images/` directory:
- Main hero image: `images/front.webp`
- Secondary hero collage: `images/mount2.webp`
- Section image: `images/mount.webp`
- Logo: `images/velocity.logo.webp`

Simply replace these files inside the `images/` folder with updated client assets matching the same file names and formats.
