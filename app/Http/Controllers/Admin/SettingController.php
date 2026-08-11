<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Mews\Purifier\Facades\Purifier;

class SettingController extends Controller
{
    /**
     * Text-only setting keys (everything except the two file uploads below).
     */
    private const TEXT_KEYS = [
        'group_name',
        'group_tagline',
        'group_bio',
        'group_portfolio_intro',
        'group_email',
        'group_phone',
        'group_whatsapp_number',
        'social_tiktok_url',
        'social_instagram_url',
        'meta_description',
        'meta_keywords',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
    ];

    public function edit(): View
    {
        return view('admin.settings.edit', ['settings' => Setting::allAsArray()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'group_name' => ['required', 'string', 'max:255'],
            'group_tagline' => ['nullable', 'string', 'max:255'],
            'group_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'group_favicon' => ['nullable', 'image', 'mimes:png,ico,jpg,jpeg', 'max:512'],
            'group_bio' => ['nullable', 'string'],
            'group_portfolio_intro' => ['nullable', 'string', 'max:1000'],
            'group_email' => ['nullable', 'email', 'max:255'],
            'group_phone' => ['nullable', 'string', 'max:50'],
            'group_whatsapp_number' => ['nullable', 'string', 'max:30'],
            'social_tiktok_url' => ['nullable', 'url', 'max:255'],
            'social_instagram_url' => ['nullable', 'url', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'mail_mailer' => ['nullable', 'string', 'max:50'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'string', 'max:10'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'max:20'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:255'],
        ]);

        if (isset($data['group_bio'])) {
            $data['group_bio'] = Purifier::clean($data['group_bio']);
        }

        // The field is always rendered blank (see edit.blade.php), so a blank
        // submission means "leave it unchanged" rather than "clear it".
        if (empty($data['mail_password'])) {
            unset($data['mail_password']);
        }

        foreach (self::TEXT_KEYS as $key) {
            if ($key === 'mail_password' && ! array_key_exists($key, $data)) {
                continue;
            }

            Setting::set($key, $data[$key] ?? null);
        }

        if ($request->hasFile('group_logo')) {
            $this->replaceFile($request, 'group_logo');
        }

        if ($request->hasFile('group_favicon')) {
            $this->replaceFile($request, 'group_favicon');
        }

        return redirect()->route('admin.settings.edit')->with('status', 'Settings updated.');
    }

    private function replaceFile(Request $request, string $key): void
    {
        $existing = Setting::get($key);

        if ($existing) {
            Storage::disk('public')->delete($existing);
        }

        Setting::set($key, $request->file($key)->store('settings', 'public'));
    }
}
