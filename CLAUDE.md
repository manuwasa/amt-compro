# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Company-profile website for **AMT Group** (a holding company) and its subsidiaries. Laravel 12 + Breeze (Blade) + Tailwind v3 + Alpine.js v3 + Quill v2, MySQL in dev (Laragon, served at `http://amt-compro.test`). It replaces the old single-company WordPress site abcjayasejahtera.com.

`docs/DEVELOPER.md` is the detailed reference (DB schema, settings keys, SEO/security conventions, step-by-step "add a new admin CRUD module"). `docs/ADMIN_GUIDE.md` covers end-user admin usage. Read DEVELOPER.md before structural changes, and keep it in sync when you change something it documents.

## Commands

```bash
composer dev                     # serve + queue + pail logs + vite, concurrently
npm run dev / npm run build      # Vite assets
php artisan migrate:fresh --seed # reset DB with demo content (companies, products, articles, settings)
php artisan admin:create         # interactive admin/superadmin creation (no admin is seeded)
php artisan storage:link         # required for uploaded images under /storage

php artisan test                                    # full suite (sqlite :memory:, see phpunit.xml)
php artisan test --filter=ProfileTest               # one class
php artisan test --filter=test_password_can_be_updated  # one method
./vendor/bin/pint                # code formatter (Laravel Pint, default preset)
```

### Known test-suite state

The suite currently has failing tests that are stale, not regressions: `RegistrationTest` and `EmailVerificationTest` exercise Breeze routes that were deliberately removed (`/register`, `/verify-email`), `AuthenticationTest`/`PasswordConfirmationTest` expect a `dashboard` route (the real one is `admin.dashboard`), and `Feature\ExampleTest` hits `/` without `RefreshDatabase`. Compare against this baseline rather than assuming you broke them.

## Architecture

**Group vs. subsidiary data split** — the central concept:
- Group-level content (name, logo, bio, contact info, socials, default SEO, *and SMTP credentials*) lives in the key-value `settings` table, accessed via `Setting::get()/set()/allAsArray()` (cached forever under `settings.all`, invalidated on save/delete). Editable only by superadmins.
- Subsidiary content lives on `Company` rows. "Our Services" (`/our-services`) is simply the list of active Companies — there is no Service model.
- `Product.company_id` is **nullable**: null means a "global" AMT Group product. Deleting a company with products is blocked (FK `restrictOnDelete()` plus a check in `Admin\CompanyController::destroy`).

**`AppServiceProvider::boot()`** runs on every HTTP request and shares `$groupSettings` and `$activeCompanies` (active, by `sort_order`, max 4) with all views, then overrides mail config from settings at runtime (8s SMTP timeout, because the contact form sends mail synchronously). It is skipped when running in console — which includes PHPUnit — and swallows DB errors. So **every view must work when `$groupSettings`/`$activeCompanies` are undefined**; use the `?? config(...)` / `!empty()` fallback pattern already in the views.

**Routes** are split: `web.php` (public) requires `auth.php` (login/logout/password-confirm only), `admin.php` (`/admin`, `auth` middleware; Settings and Users additionally behind the `superadmin` alias → `EnsureSuperAdmin`), and `redirects.php` (301s from old WordPress URLs — read its header comment first: Laravel normalizes trailing slashes, so only add redirects where the old path differs textually).

**Slugs**: `Company`, `Product`, `Article` use the `HasUniqueSlug` trait and route-model-bind by `slug`. Admin controllers compute `Model::uniqueSlug($data['slug'] ?: $data['name'], $ignoreId)` in store/update.

**Admin CRUD pattern** (follow `Admin\CompanyController` / `Admin\ArticleController`): Form Request in `app/Http/Requests/Admin/` whitelists fields → controller normalizes booleans via `$request->boolean()`, stores uploads with `->store('<dir>', 'public')`, and deletes the old file from the `public` disk on replace/destroy → redirect with `status`/`error` flash. Views are `index/create/edit/_form` under `resources/views/admin/<module>/` using `<x-admin-layout>`; add a sidebar link in `components/admin-layout.blade.php`.

**Public views** use `<x-public-layout>`, `<x-seo-meta>`, and `<x-breadcrumbs>`; page-specific JSON-LD is `@push('jsonld')`. Models expose `metaTitle()`/`metaDescription()` fallbacks. New public pages should also be added to `SitemapController`.

## Security invariants (don't regress these)

- No public registration or password reset — accounts come only from `admin:create` or Admin → Users. `users.role` defaults to `admin` and is **not** in `User::$fillable`; always set it explicitly.
- Rich HTML (Quill) is sanitized with `Purifier::clean()` before storage: `Company::setBioAttribute`, `Article::setContentAttribute`, and `group_bio` in `Admin\SettingController::update()`. Any new `{!! !!}` output of admin-supplied content needs the same treatment.
- Explicit `$fillable` on every model; never `$guarded = []`.
- JSON-LD uses `JSON_UNESCAPED_UNICODE` only — never add `JSON_UNESCAPED_SLASHES` (it allows `</script>` breakout).
- Contact form: `throttle:5,1` + honeypot field `website` (`prohibited`). Message is saved before mail is attempted; mail failures are `report()`ed, not shown to the visitor.
- Quill is pinned to exactly `2.0.2` (2.0.3 has an XSS advisory) — don't bump it.
