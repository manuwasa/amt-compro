@php($title = 'Contact Us')
@php($description = 'Get in touch with ' . ($groupSettings['group_name'] ?? config('app.name')) . '.')

<x-public-layout :title="$title" :description="$description">

    <section class="bg-slate-900 py-16 sm:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs dark :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Contact Us', 'url' => null],
            ]" />

            <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-white mt-4" data-reveal>Contact Us</h1>
            <p class="text-slate-400 mt-3 max-w-2xl" data-reveal style="transition-delay:80ms">Have a question? We'd love to hear from you.</p>
        </div>
    </section>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="grid lg:grid-cols-5 rounded-3xl overflow-hidden shadow-xl shadow-slate-200/60 ring-1 ring-slate-900/5" data-reveal>

            {{-- Dark info panel --}}
            <div class="lg:col-span-2 relative bg-slate-900 text-white p-8 sm:p-10 overflow-hidden">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 0%, rgba(245,158,11,0.16), transparent 50%);"></div>

                <div class="relative flex flex-col h-full">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-brand-400 mb-6">
                        <x-icon name="chat" class="h-6 w-6" />
                    </span>

                    <h2 class="font-display text-2xl font-bold mb-3">Let's start a conversation</h2>
                    <p class="text-slate-400 leading-relaxed mb-8">
                        Whether it's about a product, a partnership, or one of our companies — send us a message and we'll point you in the right direction.
                    </p>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start gap-3 text-sm text-slate-300">
                            <x-icon name="check" class="h-5 w-5 text-brand-400 shrink-0 mt-0.5" />
                            We read every message personally
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-300">
                            <x-icon name="check" class="h-5 w-5 text-brand-400 shrink-0 mt-0.5" />
                            Routed to the right subsidiary if needed
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-300">
                            <x-icon name="check" class="h-5 w-5 text-brand-400 shrink-0 mt-0.5" />
                            Your details are never shared or sold
                        </li>
                    </ul>

                    @if (! empty($groupSettings['group_email']) || ! empty($groupSettings['group_phone']) || ! empty($groupSettings['group_whatsapp_number']))
                        <div class="space-y-3 pt-6 border-t border-white/10 mt-auto">
                            @if (! empty($groupSettings['group_email']))
                                <a href="mailto:{{ $groupSettings['group_email'] }}" class="flex items-center gap-3 text-sm text-slate-300 hover:text-white transition-colors">
                                    <x-icon name="envelope" class="h-4 w-4 text-brand-400 shrink-0" />
                                    {{ $groupSettings['group_email'] }}
                                </a>
                            @endif
                            @if (! empty($groupSettings['group_phone']))
                                <a href="tel:{{ $groupSettings['group_phone'] }}" class="flex items-center gap-3 text-sm text-slate-300 hover:text-white transition-colors">
                                    <x-icon name="phone" class="h-4 w-4 text-brand-400 shrink-0" />
                                    {{ $groupSettings['group_phone'] }}
                                </a>
                            @endif
                            @if (! empty($groupSettings['group_whatsapp_number']))
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $groupSettings['group_whatsapp_number']) }}" target="_blank" rel="noopener" class="flex items-center gap-3 text-sm text-slate-300 hover:text-white transition-colors">
                                    <x-icon name="chat" class="h-4 w-4 text-brand-400 shrink-0" />
                                    Chat on WhatsApp
                                </a>
                            @endif
                        </div>
                    @endif

                    @if (! empty($groupSettings['social_instagram_url']) || ! empty($groupSettings['social_tiktok_url']))
                        <div class="flex gap-2 pt-6 {{ (! empty($groupSettings['group_email']) || ! empty($groupSettings['group_phone']) || ! empty($groupSettings['group_whatsapp_number'])) ? 'mt-0' : 'mt-auto border-t border-white/10' }}">
                            @if (! empty($groupSettings['social_instagram_url']))
                                <a href="{{ $groupSettings['social_instagram_url'] }}" target="_blank" rel="noopener" class="rounded-full border border-white/15 px-4 py-1.5 text-xs font-medium text-slate-300 hover:border-brand-400 hover:text-brand-400 transition-colors">Instagram</a>
                            @endif
                            @if (! empty($groupSettings['social_tiktok_url']))
                                <a href="{{ $groupSettings['social_tiktok_url'] }}" target="_blank" rel="noopener" class="rounded-full border border-white/15 px-4 py-1.5 text-xs font-medium text-slate-300 hover:border-brand-400 hover:text-brand-400 transition-colors">Tiktok</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Form panel --}}
            <div class="lg:col-span-3 bg-white p-8 sm:p-10">
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf

                    {{-- Honeypot: hidden from real visitors via CSS, left blank by them; bots often fill it in. --}}
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Your name" class="w-full rounded-xl border-2 border-transparent bg-slate-50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 transition-all duration-200">
                            @error('name') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="you@example.com" class="w-full rounded-xl border-2 border-transparent bg-slate-50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 transition-all duration-200">
                            @error('email') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Phone <span class="font-normal text-slate-400">(optional)</span></label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+62 8xx xxxx xxxx" class="w-full rounded-xl border-2 border-transparent bg-slate-50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 transition-all duration-200">
                            @error('phone') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Subject <span class="font-normal text-slate-400">(optional)</span></label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject', request('subject')) }}" placeholder="What's this about?" class="w-full rounded-xl border-2 border-transparent bg-slate-50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 transition-all duration-200">
                            @error('subject') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-2">Message</label>
                        <textarea name="message" id="message" rows="5" required placeholder="Tell us a bit about what you need..." class="w-full rounded-xl border-2 border-transparent bg-slate-50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 transition-all duration-200">{{ old('message') }}</textarea>
                        @error('message') <p class="text-sm text-red-600 mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    <x-button variant="primary" type="submit" class="w-full sm:w-auto">
                        Send Message <x-icon name="arrow-right" class="h-4 w-4" />
                    </x-button>
                </form>
            </div>
        </div>
    </div>

</x-public-layout>
