<x-admin-layout title="Group Settings">
    <p class="text-sm text-slate-500 max-w-3xl mx-auto mb-6">Controls AMT Group's own homepage, branding, and contact details — not any individual subsidiary's. Edit a specific company under <a href="{{ route('admin.companies.index') }}" class="text-brand-600 hover:underline">Companies</a> instead.</p>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-8">
        @csrf
        @method('PUT')

        <fieldset>
            <legend class="text-sm font-semibold text-slate-900 mb-4">Group Identity</legend>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="group_name" class="block text-sm font-medium text-slate-700 mb-1.5">Group Name</label>
                    <input type="text" name="group_name" id="group_name" value="{{ old('group_name', $settings['group_name'] ?? '') }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('group_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="group_tagline" class="block text-sm font-medium text-slate-700 mb-1.5">Tagline</label>
                    <input type="text" name="group_tagline" id="group_tagline" value="{{ old('group_tagline', $settings['group_tagline'] ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('group_tagline') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="group_logo" class="block text-sm font-medium text-slate-700 mb-1.5">Logo</label>
                    @if (! empty($settings['group_logo']))
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['group_logo']) }}" alt="Current logo" class="h-10 w-auto mb-2 object-contain">
                    @endif
                    <input type="file" name="group_logo" id="group_logo" accept="image/png,image/jpeg,image/webp" class="w-full text-sm">
                    @error('group_logo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="group_favicon" class="block text-sm font-medium text-slate-700 mb-1.5">Favicon</label>
                    @if (! empty($settings['group_favicon']))
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['group_favicon']) }}" alt="Current favicon" class="h-8 w-auto mb-2 object-contain">
                    @endif
                    <input type="file" name="group_favicon" id="group_favicon" accept="image/png,image/x-icon,image/jpeg" class="w-full text-sm">
                    @error('group_favicon') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        <fieldset class="border-t border-slate-100 pt-6">
            <legend class="text-sm font-semibold text-slate-900 mb-4">Homepage Content</legend>

            <x-quill-editor name="group_bio" label="Group Biography" :value="old('group_bio', $settings['group_bio'] ?? '')" />

            <div class="mt-6">
                <label for="group_portfolio_intro" class="block text-sm font-medium text-slate-700 mb-1.5">Portfolio Section Intro</label>
                <textarea name="group_portfolio_intro" id="group_portfolio_intro" rows="2" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('group_portfolio_intro', $settings['group_portfolio_intro'] ?? '') }}</textarea>
                @error('group_portfolio_intro') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </fieldset>

        <fieldset class="border-t border-slate-100 pt-6">
            <legend class="text-sm font-semibold text-slate-900 mb-4">Group Contact &amp; Social</legend>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="group_email" class="block text-sm font-medium text-slate-700 mb-1.5">Group Email</label>
                    <input type="email" name="group_email" id="group_email" value="{{ old('group_email', $settings['group_email'] ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('group_email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="group_phone" class="block text-sm font-medium text-slate-700 mb-1.5">Group Phone</label>
                    <input type="text" name="group_phone" id="group_phone" value="{{ old('group_phone', $settings['group_phone'] ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('group_phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="group_whatsapp_number" class="block text-sm font-medium text-slate-700 mb-1.5">Group WhatsApp Number</label>
                    <input type="text" name="group_whatsapp_number" id="group_whatsapp_number" value="{{ old('group_whatsapp_number', $settings['group_whatsapp_number'] ?? '') }}" placeholder="62812xxxxxxx" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('group_whatsapp_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="social_instagram_url" class="block text-sm font-medium text-slate-700 mb-1.5">Instagram URL</label>
                    <input type="url" name="social_instagram_url" id="social_instagram_url" value="{{ old('social_instagram_url', $settings['social_instagram_url'] ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('social_instagram_url') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="social_tiktok_url" class="block text-sm font-medium text-slate-700 mb-1.5">Tiktok URL</label>
                    <input type="url" name="social_tiktok_url" id="social_tiktok_url" value="{{ old('social_tiktok_url', $settings['social_tiktok_url'] ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('social_tiktok_url') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        <fieldset class="border-t border-slate-100 pt-6">
            <legend class="text-sm font-semibold text-slate-900 mb-4">Default SEO</legend>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-slate-700 mb-1.5">Default Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" maxlength="500" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                    @error('meta_description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-slate-700 mb-1.5">Default Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('meta_keywords') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        <fieldset class="border-t border-slate-100 pt-6">
            <legend class="text-sm font-semibold text-slate-900 mb-1">SMTP</legend>
            <p class="text-sm text-slate-500 mb-4">Once this and Group Email above are filled in, every Contact Us submission also emails a notification to Group Email — in addition to always appearing in Messages.</p>

            <details class="group mb-6 rounded-xl border border-slate-200 bg-slate-50">
                <summary class="cursor-pointer select-none px-4 py-3 text-sm font-medium text-slate-700 flex items-center justify-between">
                    <span>Need help finding these details?</span>
                    <x-icon name="chevron-down" class="h-4 w-4 text-slate-400 transition-transform group-open:rotate-180" />
                </summary>

                <div class="px-4 pb-4 pt-1 text-sm text-slate-600 space-y-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead class="text-left text-slate-500">
                                <tr>
                                    <th class="pr-4 py-1.5 font-semibold">Provider</th>
                                    <th class="pr-4 py-1.5 font-semibold">Host</th>
                                    <th class="pr-4 py-1.5 font-semibold">Port</th>
                                    <th class="pr-4 py-1.5 font-semibold">Encryption</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                <tr>
                                    <td class="pr-4 py-1.5">Google Workspace / Gmail</td>
                                    <td class="pr-4 py-1.5 font-mono">smtp.gmail.com</td>
                                    <td class="pr-4 py-1.5">587</td>
                                    <td class="pr-4 py-1.5">tls</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 py-1.5">Zoho Mail</td>
                                    <td class="pr-4 py-1.5 font-mono">smtp.zoho.com</td>
                                    <td class="pr-4 py-1.5">587</td>
                                    <td class="pr-4 py-1.5">tls</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 py-1.5">Microsoft 365 / Outlook</td>
                                    <td class="pr-4 py-1.5 font-mono">smtp.office365.com</td>
                                    <td class="pr-4 py-1.5">587</td>
                                    <td class="pr-4 py-1.5">tls</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 py-1.5">Your hosting provider's email</td>
                                    <td class="pr-4 py-1.5 font-mono">mail.yourdomain.com<span class="font-sans">*</span></td>
                                    <td class="pr-4 py-1.5">587</td>
                                    <td class="pr-4 py-1.5">tls</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-xs text-slate-400 mt-1">*Check your hosting control panel — the exact host varies.</p>
                    </div>

                    <ul class="list-disc pl-4 space-y-1">
                        <li><strong>Google, Microsoft, and Zoho</strong> all require an <strong>app-specific password</strong> here (not your regular login password) once two-factor authentication is turned on — Gmail's is generated at <span class="font-mono">myaccount.google.com/apppasswords</span>.</li>
                        <li><strong>From Address should match Username</strong> — most providers reject or flag mail otherwise.</li>
                        <li>Port <strong>587</strong> pairs with <strong>tls</strong>; port <strong>465</strong> pairs with <strong>ssl</strong>. Mixing them is the most common cause of a silent failure. Avoid port 25, it's commonly blocked.</li>
                    </ul>
                </div>
            </details>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="mail_mailer" class="block text-sm font-medium text-slate-700 mb-1.5">Mailer</label>
                    <input type="text" name="mail_mailer" id="mail_mailer" value="{{ old('mail_mailer', $settings['mail_mailer'] ?? '') }}" placeholder="smtp" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_mailer') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mail_host" class="block text-sm font-medium text-slate-700 mb-1.5">Host</label>
                    <input type="text" name="mail_host" id="mail_host" value="{{ old('mail_host', $settings['mail_host'] ?? '') }}" placeholder="smtp.gmail.com" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_host') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mail_port" class="block text-sm font-medium text-slate-700 mb-1.5">Port</label>
                    <input type="text" name="mail_port" id="mail_port" value="{{ old('mail_port', $settings['mail_port'] ?? '') }}" placeholder="587" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_port') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mail_encryption" class="block text-sm font-medium text-slate-700 mb-1.5">Encryption</label>
                    <input type="text" name="mail_encryption" id="mail_encryption" value="{{ old('mail_encryption', $settings['mail_encryption'] ?? '') }}" placeholder="tls" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_encryption') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mail_username" class="block text-sm font-medium text-slate-700 mb-1.5">Username</label>
                    <input type="text" name="mail_username" id="mail_username" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}" placeholder="you@amtgroup.co.id" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_username') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mail_password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Password <span class="font-normal text-slate-400">(app-specific if 2FA is on)</span>
                    </label>
                    <input type="password" name="mail_password" id="mail_password" value="{{ old('mail_password') }}" placeholder="{{ ! empty($settings['mail_password']) ? 'Currently set — leave blank to keep it' : 'Not set' }}" autocomplete="new-password" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mail_from_address" class="block text-sm font-medium text-slate-700 mb-1.5">
                        From Address <span class="font-normal text-slate-400">(should match Username)</span>
                    </label>
                    <input type="email" name="mail_from_address" id="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}" placeholder="you@amtgroup.co.id" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_from_address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="mail_from_name" class="block text-sm font-medium text-slate-700 mb-1.5">From Name</label>
                    <input type="text" name="mail_from_name" id="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}" placeholder="AMT Group" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('mail_from_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        <div>
            <x-button variant="primary" type="submit">Save Settings</x-button>
        </div>
    </form>
</x-admin-layout>
