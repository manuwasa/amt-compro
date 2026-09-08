# Developer Guide

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Local Setup](#local-setup)
3. [Project Structure](#project-structure)
4. [Architecture Overview](#architecture-overview)
5. [Database Schema](#database-schema)
6. [Roles & Authorization](#roles--authorization)
7. [Settings System](#settings-system)
8. [Frontend Stack](#frontend-stack)
9. [SEO](#seo)
10. [Security](#security)
11. [Adding a New CRUD Module](#adding-a-new-crud-module)
12. [Running Tests](#running-tests)
13. [Useful Artisan Commands](#useful-artisan-commands)

---

## Prerequisites

| Tool | Version |
|------|---------|
| PHP | 8.2 or higher |
| Composer | 2.x |
| Node.js | 18+ |
| npm | 9+ |
| MySQL / MariaDB | 8.x / 10.x |

---

## Local Setup

```bash
# 1. Clone or copy the project
cd c:/laragon/www
# (project already at amt-compro/)

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# 4. Create the MySQL database (via Laragon, phpMyAdmin, or the CLI)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS amt_compro CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
# then set DB_DATABASE=amt_compro (and credentials) in .env

# 5. Run migrations and seed default + demo data
php artisan migrate --seed

# 6. Create the storage symlink (makes uploaded files accessible via /storage/...)
php artisan storage:link

# 7. Install Node dependencies and build assets
npm install
npm run dev   # or: npm run build for a one-time production build
```

After setup, visit `http://amt-compro.test` (Laragon) or `http://127.0.0.1:8000` (`php artisan serve`).

### Creating Your First Admin User

No admin user is seeded in plaintext. Create one interactively:

```bash
php artisan admin:create
```

It prompts for name, email, password, and role (`superadmin` or `admin`).

> If your terminal doesn't support the hidden password prompt (some non-interactive shells don't), create the user via `php artisan tinker` instead, setting `$user->password = Hash::make('...')` and `$user->role` explicitly — never rely on mass assignment for `role`, since it's deliberately excluded from `User::$fillable` (see [Security](#security)).

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                  # All admin panel controllers
│   │   │   ├── ArticleController.php
│   │   │   ├── CompanyController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── MessageController.php
│   │   │   ├── ProductController.php   # top-level; company is an optional field on the product
│   │   │   ├── SettingController.php
│   │   │   └── UserController.php
│   │   ├── ArticleController.php   # Public "News & Artikel"
│   │   ├── CompanyController.php   # Public "Our Services" directory + profile
│   │   ├── ContactController.php
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   └── SitemapController.php
│   ├── Middleware/
│   │   ├── EnsureSuperAdmin.php
│   │   └── SecurityHeaders.php
│   └── Requests/
│       ├── Admin/                  # CompanyRequest, ProductRequest, ArticleRequest, UserRequest
│       └── ContactRequest.php
├── Mail/
│   └── NewContactMessage.php       # sent to Setting::get('group_email') on each contact submission
├── Models/
│   ├── Concerns/
│   │   └── HasUniqueSlug.php       # shared by Company, Product, Article
│   ├── Article.php
│   ├── Company.php                 # a subsidiary of AMT Group
│   ├── ContactMessage.php
│   ├── Product.php                 # belongsTo Company (nullable — a product may be "global")
│   ├── Setting.php                 # key-value settings store
│   └── User.php
├── Console/Commands/
│   └── CreateAdminUser.php         # `php artisan admin:create`
└── Providers/
    └── AppServiceProvider.php      # shares $groupSettings + $activeCompanies to all views
resources/
├── css/app.css                     # Tailwind imports
├── js/app.js                       # Alpine.js + Quill editor init
└── views/
    ├── admin/                      # Admin panel Blade templates
    ├── articles/                   # Public News & Artikel views
    ├── companies/                  # Public "Our Services" directory + profile
    ├── products/
    ├── components/
    │   ├── public-layout.blade.php # <x-public-layout> — public site chrome
    │   ├── admin-layout.blade.php  # <x-admin-layout> — admin sidebar chrome
    │   ├── seo-meta.blade.php      # <x-seo-meta> — title/description/OG/Twitter tags
    │   ├── breadcrumbs.blade.php   # <x-breadcrumbs> — visible trail + BreadcrumbList JSON-LD
    │   └── quill-editor.blade.php  # <x-quill-editor> — Quill field + hidden input sync
    ├── home.blade.php
    ├── contact.blade.php
    └── sitemap.blade.php           # raw XML view
database/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    ├── SettingSeeder.php
    ├── CompanySeeder.php           # CV AMT Jaya Ban + PT ABC Jaya Sejahtera (real content) + CV B/C (placeholders)
    ├── ProductSeeder.php           # Befriend tire models under PT ABC Jaya Sejahtera
    └── ArticleSeeder.php
routes/
├── web.php                         # public routes
├── admin.php                       # admin panel routes (required from web.php)
├── redirects.php                   # old abcjayasejahtera.com → new path 301s (see SEO)
└── auth.php                        # login/logout + password confirm (no public register, no password reset)
```

---

## Architecture Overview

### Request Flow

```
Browser → routes/web.php (+ admin.php, redirects.php) → Middleware (auth / superadmin) → Controller → Model → View
```

### The Group ↔ Subsidiary Model

AMT Group is the holding company; **Companies** are its subsidiaries (PT ABC Jaya Sejahtera, CV A, CV B, CV C). This is the key structural difference from a typical single-company site:

- **Group-level** content (homepage bio/portfolio, group contact info, socials, default SEO) lives in the `settings` key-value table, managed via **Admin → Group Settings**.
- **Subsidiary-level** content (bio, address, phone, WhatsApp, email, products) lives on each `Company` row, managed via **Admin → Companies**.
- **Products** usually belong to one `Company` (`company_id` FK), but `company_id` is nullable — a product with no company is "global," shown in the flat `/products` catalog and attributed to AMT Group itself rather than any subsidiary. Deleting a company that still has linked products is blocked (`restrictOnDelete()`); reassign or delete its products first. "Our Services" on the public site is literally the list of active Companies; there is no separate `Service` model.

### View Data Sharing

`AppServiceProvider::boot()` runs on every web request (guarded against the console and against running before migrations exist) and:
- Queries all settings from the `settings` table and shares them as `$groupSettings` with every view.
- Shares `$activeCompanies` (active companies, ordered by `sort_order`) so the nav/footer can list them without every controller passing them explicitly.
- Applies mail configuration from `$groupSettings` at runtime, overriding `.env` SMTP settings when `mail_host` is set. The SMTP transport's `timeout` is deliberately capped at 8 seconds here — `ContactController::store()` sends `NewContactMessage` synchronously (no queue worker assumed), so an unreachable/misconfigured host must fail fast rather than hanging the visitor's request. The message is always saved first regardless of whether the email send succeeds; failures are caught and `report()`-ed, never surfaced to the visitor.

### Route Groups

```php
// Public — no auth required
Route::get('/', ...)                          // home
Route::get('/our-services/{company:slug}', ...) // subsidiary profile

// Admin — auth required (any logged-in user)
Route::prefix('admin')->middleware(['auth'])
    Route::resource('companies', ...)
    Route::resource('products', ...)       // top-level; ?company=slug filters the index
    Route::resource('articles', ...)
    Route::get('messages', ...)

    // Superadmin only
    Route::middleware('superadmin')
        Route::get/put 'settings'
        Route::resource('users', ...)
```

---

## Database Schema

### `companies`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name | varchar(255) | |
| slug | varchar(255) | unique, used in URL |
| logo | varchar(255) | nullable, path in public disk |
| cover_image | varchar(255) | nullable |
| bio | longtext | nullable, sanitized HTML from Quill (`Company::setBioAttribute`) |
| address | text | nullable |
| phone | varchar(50) | nullable |
| whatsapp_number | varchar(30) | nullable, digits only — used to build `wa.me` links |
| email | varchar(255) | nullable |
| is_active | boolean | default true |
| sort_order | smallint | default 0 |
| meta_title / meta_description | varchar | nullable, fall back to name/bio |

### `products`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| company_id | FK → companies.id | nullable — null means "global" (not tied to a subsidiary); `restrictOnDelete()` when set |
| brand | varchar(100) | nullable |
| name | varchar(255) | |
| slug | varchar(255) | unique (global, not per-company) |
| description | text | nullable, plain text — not Quill |
| image | varchar(255) | nullable |
| gallery | json | nullable, array of additional image paths |
| category | varchar(100) | nullable |
| is_active | boolean | default true |
| sort_order | smallint | default 0 |
| meta_title / meta_description | varchar | nullable |

### `articles`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| user_id | FK → users.id | nullable, `nullOnDelete()` |
| title | varchar(255) | |
| slug | varchar(255) | unique |
| excerpt | text | nullable |
| content | longtext | sanitized HTML from Quill (`Article::setContentAttribute`) |
| featured_image | varchar(255) | nullable |
| featured_image_alt | varchar(255) | nullable, falls back to title |
| tags | varchar(255) | nullable, comma-separated |
| category | varchar(100) | nullable |
| meta_title / meta_description | varchar | nullable |
| is_published | boolean | default false |
| published_at | timestamp | nullable |

### `settings`
| Column | Type | Notes |
|--------|------|-------|
| key | varchar(255) PK | not auto-increment |
| value | longtext | nullable |

**Stored setting keys:** `group_name`, `group_tagline`, `group_logo`, `group_favicon`, `group_bio`, `group_portfolio_intro`, `group_email`, `group_phone`, `group_whatsapp_number`, `social_tiktok_url`, `social_instagram_url`, `meta_description`, `meta_keywords`, `mail_mailer`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`

### `contact_messages`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name / email / phone / subject | varchar | phone & subject nullable |
| message | text | |
| is_read | boolean | default false |

### `users`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name / email / password | | standard Breeze fields |
| role | varchar(255) | `superadmin` or `admin`, default `admin` — **not** mass-assignable |

---

## Roles & Authorization

| Feature | admin | superadmin |
|---------|:-----:|:----------:|
| Dashboard | ✓ | ✓ |
| Companies | ✓ | ✓ |
| Products | ✓ | ✓ |
| Articles | ✓ | ✓ |
| Contact messages | ✓ | ✓ |
| Group Settings | — | ✓ |
| Users | — | ✓ |

The `EnsureSuperAdmin` middleware (`app/Http/Middleware/EnsureSuperAdmin.php`) enforces superadmin access. It is registered in `bootstrap/app.php` as the alias `superadmin`.

```php
auth()->user()->isSuperAdmin()  // bool
auth()->user()->isAdmin()       // bool — true for both roles
```

There is **no public self-registration** — the `/register` route was removed entirely (see [Security](#security)).

---

## Settings System

Identical pattern to a typical key-value settings store, with an in-process cache:

```php
Setting::get('group_email');
Setting::get('group_email', 'fallback@example.com'); // with default
Setting::set('group_name', 'AMT Group');
Setting::allAsArray(); // ['group_name' => '...', ...] — cached forever, invalidated on save/delete
```

In any Blade template, settings are always available via `$groupSettings`:
```blade
{{ $groupSettings['group_name'] ?? config('app.name') }}
{!! $groupSettings['group_bio'] ?? '' !!}  {{-- already-sanitized HTML --}}
```

---

## Frontend Stack

| Tool | Purpose |
|------|---------|
| Tailwind CSS v3 | Utility-first styling |
| Alpine.js v3 | Lightweight reactivity (live SEO character counters, etc.) |
| Quill v2 | Rich text editor for Company bio, Article content, Group bio |
| Vite | Asset bundling and HMR |

### Quill Editor

Use the `<x-quill-editor>` component rather than wiring Quill by hand:

```blade
<x-quill-editor name="bio" label="Biography" :value="old('bio', $company->bio)" />
```

Under the hood, `resources/js/app.js` initializes a Quill instance on every `[data-quill]` container and syncs its HTML into the hidden input named by `[data-quill-target]` on every edit — the surrounding `<form>` submits plain HTML with no extra JS on the server side. All Quill-produced HTML is sanitized server-side via `Purifier::clean()` before it's ever stored (see [Security](#security)) — never trust it as safe just because it came from the editor.

### Building Assets

```bash
npm run dev    # watch mode with HMR (development)
npm run build  # production build with hashed filenames
```

---

## SEO

- Every public page includes `<x-seo-meta>` (title, description, canonical, Open Graph, Twitter Card) and `<x-breadcrumbs>` (visible trail + `BreadcrumbList` JSON-LD).
- Page-specific structured data (`Organization`, `LocalBusiness`, `Product`, `BlogPosting`) is pushed via `@push('jsonld')` in each show view and rendered in `<x-public-layout>`'s `<head>` via `@stack('jsonld')`.
- `Company`, `Product`, and `Article` all carry `meta_title`/`meta_description` columns that fall back to their primary content field when left blank — see each model's `metaTitle()`/`metaDescription()` helper.
- `/sitemap.xml` (`SitemapController`) enumerates static pages + active companies + active products + published articles with `lastmod`/`changefreq`/`priority`. `/robots.txt` is a static file in `public/` referencing it.
- `routes/redirects.php` holds 301 redirects from the old abcjayasejahtera.com URL structure to this site's new paths, ready to activate once that domain's DNS points here. **Read the comment block at the top of that file before adding to it** — Laravel normalizes trailing slashes on both route registration and request matching, so a redirect whose old and new paths differ only by a trailing slash is a no-op (or worse, a self-redirect that shadows the real route). Only add a redirect when the old path is textually different from its new equivalent.

---

## Security

- `.env` is git-ignored from the first commit; only `.env.example` (placeholder values) is committed. Never commit real DB/mail credentials.
- The `/register` route is intentionally not exposed: `users.role` defaults to `admin` in the migration, so an open self-registration endpoint would let anyone grant themselves admin-panel access. Accounts are created only via `php artisan admin:create` or **Admin → Users**, both of which set `role` explicitly rather than through mass assignment (`role` is deliberately excluded from `User::$fillable`).
- `Company::bio` and `Article::content` — the two Quill-authored HTML fields rendered with `{!! !!}` — are sanitized through `Mews\Purifier` in their respective model mutators (`setBioAttribute`/`setContentAttribute`) before ever reaching the database. `Setting::group_bio` is sanitized in `Admin\SettingController::update()` for the same reason. Do not add a new `{!! !!}` output of user/admin-supplied content without sanitizing it the same way.
- Every model has an explicit `$fillable` list (never `$guarded = []`). Admin Form Requests (`app/Http/Requests/Admin/*`) whitelist exactly the fields exposed in each form.
- File uploads (`logo`, `cover_image`, `image`, `gallery.*`, `featured_image`, `group_logo`, `group_favicon`) are validated via Form Request rules (`image`, explicit `mimes:`, `max:` size) and stored via Laravel's `store()` helper, which generates a randomized filename — never the original, user-supplied filename.
- The public contact form (`ContactRequest`) includes a honeypot field (`website`, rule `prohibited`) in addition to `throttle:5,1` on the route.
- `SecurityHeaders` middleware (registered globally in `bootstrap/app.php`) sets `X-Content-Type-Options`, `X-Frame-Options`, and `Referrer-Policy` on every response.
- JSON-LD `<script>` blocks encode with `JSON_UNESCAPED_UNICODE` only — **not** `JSON_UNESCAPED_SLASHES` — so that a `</script>` substring inside any field value can't break out of the script tag.
- Run `composer audit` and `npm audit` periodically; both were clean as of this build (Quill is pinned to `2.0.2` to avoid a low-severity XSS advisory in `2.0.3` that has no newer fix yet).

---

## Adding a New CRUD Module

Example: adding a "Testimonials" module (superadmin only), following the same pattern as `Company`/`Product`/`Article`.

### 1. Migration
```bash
php artisan make:migration create_testimonials_table
```
```php
Schema::create('testimonials', function (Blueprint $table) {
    $table->id();
    $table->string('author');
    $table->string('company')->nullable();
    $table->text('body');
    $table->boolean('is_active')->default(true);
    $table->unsignedSmallInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 2. Model
```bash
php artisan make:model Testimonial
```
```php
protected $fillable = ['author', 'company', 'body', 'is_active', 'sort_order'];
protected $casts = ['is_active' => 'boolean'];
```

### 3. Controller
```bash
php artisan make:controller Admin/TestimonialController --resource --model=Testimonial
```
Implement `index`, `create`, `store`, `edit`, `update`, `destroy` following the pattern in `Admin\ArticleController`.

### 4. Route (in `routes/admin.php`, inside the `superadmin` middleware group)
```php
Route::resource('testimonials', TestimonialController::class)->except('show');
```

### 5. Views
Create `resources/views/admin/testimonials/{index,create,edit,_form}.blade.php` using `<x-admin-layout>`, following `resources/views/admin/articles/` as the template.

### 6. Sidebar Link (in `resources/views/components/admin-layout.blade.php`)
```blade
<a href="{{ route('admin.testimonials.index') }}"
   class="block rounded-md px-3 py-2 {{ request()->routeIs('admin.testimonials.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
    Testimonials
</a>
```

---

## Running Tests

```bash
php artisan test
# or
./vendor/bin/phpunit
```

Tests live in `tests/Feature/` (HTTP tests) and `tests/Unit/` (unit tests). The project ships with Breeze's default auth tests (registration tests were removed along with the `/register` route).

---

## Useful Artisan Commands

```bash
# Clear all caches (run after config/route changes)
php artisan optimize:clear

# Re-cache for production
php artisan optimize

# Open an interactive REPL
php artisan tinker

# Run migrations fresh (drops and recreates all tables) and reseed
php artisan migrate:fresh --seed

# List all registered routes
php artisan route:list

# Create a storage symlink
php artisan storage:link

# Create an admin/superadmin user interactively
php artisan admin:create
```
