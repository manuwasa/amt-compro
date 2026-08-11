# AMT Group — Company Profile Website

A multi-company profile website for **AMT Group**, a holding company with several subsidiaries (currently PT ABC Jaya Sejahtera, CV A, CV B, CV C). Replaces the previous single-company WordPress site at abcjayasejahtera.com.

## Stack

Laravel 12 · Breeze (Blade) · Tailwind CSS v3 · Alpine.js v3 · Quill v2 · MySQL

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
# create a MySQL database and set DB_* in .env, then:
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan admin:create
```

Visit `http://amt-compro.test` (Laragon) or run `php artisan serve`.

## Documentation

- [`docs/DEVELOPER.md`](docs/DEVELOPER.md) — project structure, database schema, SEO/security conventions, how to add a new admin CRUD module.
- [`docs/ADMIN_GUIDE.md`](docs/ADMIN_GUIDE.md) — how to manage Companies, Products, Articles, Users, and Group Settings through the admin panel.

## Site Structure

- **Homepage** — AMT Group's own bio and a portfolio grid of its subsidiary companies.
- **Our Services** — directory of subsidiary companies, each with its own profile, bio, contact info, and products.
- **Products** — flat catalog, each either scoped to one subsidiary company or "global" (available across AMT Group, not tied to a specific subsidiary).
- **News & Artikel** — SEO-oriented blog/article system.
- **Contact Us** — group-level contact form, social links, email, and WhatsApp.
