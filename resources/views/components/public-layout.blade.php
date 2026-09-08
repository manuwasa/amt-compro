<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Progressive enhancement: only start hiding [data-reveal] content once we know JS
    runs (see app.css). Runs synchronously before paint, so there's no flash of hidden content. --}}
    <script>
        document.documentElement.classList.add('reveal-ready')
    </script>

    <x-seo-meta :title="$title ?? null" :description="$description ?? null" :image="$image ?? null" :type="$ogType ?? 'website'" />

    @stack('jsonld')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-white text-slate-900 antialiased font-sans">

    <header x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 12)" class="sticky top-0 z-40 transition-all duration-300"
        :class="scrolled ? 'bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm' :
            'bg-white/0 border-b border-transparent'">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            {{-- Wordmark only: the header shows the group name as plain text, no logo image or initial badge. --}}
            <a href="{{ route('home') }}" class="font-display font-bold text-lg text-slate-900 shrink-0">
                {{ $groupSettings['group_name'] ?? config('app.name') }}
            </a>

            <div class="hidden lg:flex items-center gap-1 text-sm font-medium">
                @foreach ([['label' => 'Home', 'route' => 'home', 'active' => 'home'], ['label' => 'Our Services', 'route' => 'companies.index', 'active' => 'companies.*'], ['label' => 'Products', 'route' => 'products.index', 'active' => 'products.*'], ['label' => 'News & Artikel', 'route' => 'articles.index', 'active' => 'articles.*']] as $link)
                    <a href="{{ route($link['route']) }}"
                        class="group relative px-4 py-2 {{ request()->routeIs($link['active']) ? 'text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">
                        {{ $link['label'] }}
                        <span
                            class="absolute left-4 right-4 -bottom-0.5 h-0.5 rounded-full bg-brand-500 origin-left transition-transform duration-300 {{ request()->routeIs($link['active']) ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100' }}"></span>
                    </a>
                @endforeach
            </div>

            <div class="hidden lg:block">
                <x-button variant="primary" href="{{ route('contact') }}">
                    Contact Us
                </x-button>
            </div>

            <button @click="open = ! open" type="button"
                class="lg:hidden relative h-10 w-10 flex items-center justify-center rounded-full text-slate-700 hover:bg-slate-100"
                aria-label="Toggle menu">
                <svg class="h-6 w-6 transition-all duration-300"
                    :class="open ? 'rotate-90 scale-0 opacity-0 absolute' : 'rotate-0 scale-100 opacity-100'"
                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg class="h-6 w-6 transition-all duration-300"
                    :class="open ? 'rotate-0 scale-100 opacity-100' : '-rotate-90 scale-0 opacity-0 absolute'"
                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" x-cloak
            class="lg:hidden bg-white border-b border-slate-200 shadow-lg px-4 sm:px-6 py-4 space-y-1 text-sm font-medium">
            <a href="{{ route('home') }}"
                class="block rounded-lg px-3 py-2.5 {{ request()->routeIs('home') ? 'bg-slate-100 text-slate-900' : 'text-slate-600' }}">Home</a>
            <a href="{{ route('companies.index') }}"
                class="block rounded-lg px-3 py-2.5 {{ request()->routeIs('companies.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-600' }}">Our
                Services</a>
            <a href="{{ route('products.index') }}"
                class="block rounded-lg px-3 py-2.5 {{ request()->routeIs('products.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-600' }}">Products</a>
            <a href="{{ route('articles.index') }}"
                class="block rounded-lg px-3 py-2.5 {{ request()->routeIs('articles.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-600' }}">News
                &amp; Artikel</a>
            <a href="{{ route('contact') }}"
                class="block rounded-lg px-3 py-2.5 {{ request()->routeIs('contact') ? 'bg-slate-100 text-slate-900' : 'text-slate-600' }}">Contact
                Us</a>
        </div>
    </header>

    <main class="flex-1">
        @if (session('status'))
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" data-reveal>
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-slate-900 text-slate-300 mt-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2.5 font-display font-bold text-lg text-white mb-3">
                    @if (!empty($groupSettings['group_logo']))
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($groupSettings['group_logo']) }}"
                            alt="{{ $groupSettings['group_name'] ?? config('app.name') }}" class="h-8 w-auto">
                    @endif
                    <span>{{ $groupSettings['group_name'] ?? config('app.name') }}</span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">{{ $groupSettings['group_tagline'] ?? '' }}</p>
            </div>

            <div>
                <div class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Our Services</div>
                <ul class="space-y-2.5 text-sm">
                    @foreach ($activeCompanies ?? [] as $activeCompany)
                        <li><a href="{{ route('companies.show', $activeCompany) }}"
                                class="text-slate-400 hover:text-brand-400 transition-colors">{{ $activeCompany->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <div class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Explore</div>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('companies.index') }}"
                            class="text-slate-400 hover:text-brand-400 transition-colors">Our Services</a></li>
                    <li><a href="{{ route('products.index') }}"
                            class="text-slate-400 hover:text-brand-400 transition-colors">Products</a></li>
                    <li><a href="{{ route('articles.index') }}"
                            class="text-slate-400 hover:text-brand-400 transition-colors">News &amp; Artikel</a></li>
                    <li><a href="{{ route('contact') }}"
                            class="text-slate-400 hover:text-brand-400 transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <div class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Address</div>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="text-slate-400 hover:text-brand-400 transition-colors">Jl. Teuku Umar,
                            Gg. Kantor Pos
                            RT.004 RW.005 DS. Telaga Asih, Kec. Cikarang, Kab. Bekasi</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-brand-400 transition-colors">021 221 627
                            22</a></li>
                    <li><a href="#"
                            class="text-slate-400 hover:text-brand-400 transition-colors">abc.official@sabcjaya.co.id</a>
                    </li>

                </ul>
            </div>

            <div>
                <div class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Contact</div>
                <ul class="space-y-2.5 text-sm">
                    @if (!empty($groupSettings['group_email']))
                        <li><a href="mailto:{{ $groupSettings['group_email'] }}"
                                class="text-slate-400 hover:text-brand-400 transition-colors">{{ $groupSettings['group_email'] }}</a>
                        </li>
                    @endif
                    @if (!empty($groupSettings['group_whatsapp_number']))
                        <li><a href="https://wa.me/{{ preg_replace('/\D/', '', $groupSettings['group_whatsapp_number']) }}"
                                class="text-slate-400 hover:text-brand-400 transition-colors" target="_blank"
                                rel="noopener">WhatsApp</a></li>
                    @endif
                    @if (empty($groupSettings['group_email']) && empty($groupSettings['group_whatsapp_number']))
                        <li><a href="{{ route('contact') }}"
                                class="text-slate-400 hover:text-brand-400 transition-colors">Get in touch &rarr;</a>
                        </li>
                    @endif
                </ul>

                @if (!empty($groupSettings['social_instagram_url']) || !empty($groupSettings['social_tiktok_url']))
                    <div class="flex gap-2 mt-5">
                        @if (!empty($groupSettings['social_instagram_url']))
                            <a href="{{ $groupSettings['social_instagram_url'] }}" target="_blank" rel="noopener"
                                class="rounded-full border border-slate-700 px-3.5 py-1.5 text-xs font-medium text-slate-300 hover:border-brand-500 hover:text-brand-400 transition-colors">Instagram</a>
                        @endif
                        @if (!empty($groupSettings['social_tiktok_url']))
                            <a href="{{ $groupSettings['social_tiktok_url'] }}" target="_blank" rel="noopener"
                                class="rounded-full border border-slate-700 px-3.5 py-1.5 text-xs font-medium text-slate-300 hover:border-brand-500 hover:text-brand-400 transition-colors">Tiktok</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t border-slate-800 py-6">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} {{ $groupSettings['group_name'] ?? config('app.name') }}. All rights
                reserved.
            </div>
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
                <a href="https://www.putrateknologiindonesia.com">
                    Crafted With ♥ by putrateknologiindonesia.
                </a>
            </div>
        </div>
    </footer>

</body>

</html>
