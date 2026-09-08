<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $this->shareGroupSettings();
    }

    /**
     * Share the database-backed group branding (name, logo, contact details, social
     * links) and the footer's company list with every view, then apply the stored
     * SMTP credentials.
     *
     * This runs on every HTTP request, before routing, so a database that is
     * unreachable or not yet migrated must not be allowed to throw past here: doing so
     * turns *every* URL into a 500 — including /up and the 404 page, which are exactly
     * what you need working to tell an app-level bug apart from a database outage.
     * Views read each of these values through a `?? config(...)` / `!empty()` fallback,
     * so skipping the share degrades to the config defaults instead of breaking them.
     */
    private function shareGroupSettings(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            $groupSettings = Setting::allAsArray();
            $activeCompanies = Company::where('is_active', true)
                ->orderBy('sort_order')
                ->limit(4)
                ->get();
        } catch (Throwable $e) {
            report($e);

            return;
        }

        View::share('groupSettings', $groupSettings);
        View::share('activeCompanies', $activeCompanies);

        $this->applyMailSettings($groupSettings);
    }

    /**
     * Override the default mail config with values stored in the `settings` table,
     * so the group's SMTP credentials can be managed from the admin panel.
     */
    private function applyMailSettings(array $groupSettings): void
    {
        if (empty($groupSettings['mail_host'])) {
            return;
        }

        config([
            'mail.default' => $groupSettings['mail_mailer'] ?? config('mail.default'),
            'mail.mailers.smtp.host' => $groupSettings['mail_host'],
            'mail.mailers.smtp.port' => $groupSettings['mail_port'] ?? config('mail.mailers.smtp.port'),
            'mail.mailers.smtp.username' => $groupSettings['mail_username'] ?? null,
            'mail.mailers.smtp.password' => $groupSettings['mail_password'] ?? null,
            'mail.mailers.smtp.encryption' => $groupSettings['mail_encryption'] ?? null,
            // Mail is sent synchronously from the contact form (no queue worker is
            // assumed to be running), so a short timeout keeps a misconfigured or
            // unreachable host from hanging the visitor's request for 20+ seconds.
            'mail.mailers.smtp.timeout' => 8,
            'mail.from.address' => $groupSettings['mail_from_address'] ?? config('mail.from.address'),
            'mail.from.name' => $groupSettings['mail_from_name'] ?? config('mail.from.name'),
        ]);
    }
}
