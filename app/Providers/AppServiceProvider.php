<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->runningInConsole() || ! Schema::hasTable('settings')) {
            return;
        }

        $groupSettings = Setting::allAsArray();

        View::share('groupSettings', $groupSettings);
        View::share('activeCompanies', Company::where('is_active', true)->orderBy('sort_order')->limit(4)->get());

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
