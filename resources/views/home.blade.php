<x-public-layout>

    @push('jsonld')
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => $groupSettings['group_name'] ?? config('app.name'),
                'url' => route('home'),
                'logo' => ! empty($groupSettings['group_logo']) ? \Illuminate\Support\Facades\Storage::url($groupSettings['group_logo']) : null,
                'sameAs' => array_values(array_filter([
                    $groupSettings['social_instagram_url'] ?? null,
                    $groupSettings['social_tiktok_url'] ?? null,
                ])),
            ], JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 15% 20%, rgba(245,158,11,0.18), transparent 45%), radial-gradient(circle at 85% 0%, rgba(245,158,11,0.10), transparent 40%);">
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-28 sm:py-36 text-center">
            <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-400 mb-8"
                data-reveal>
                {{ ($activeCompanies ?? collect())->count() }} Subsidiary
                {{ ($activeCompanies ?? collect())->count() === 1 ? 'Company' : 'Companies' }}
            </p>

            <h1 class="font-display text-4xl sm:text-6xl font-bold tracking-tight text-white mb-6" data-reveal
                style="transition-delay:80ms">
                {{ $groupSettings['group_name'] ?? config('app.name') }}
            </h1>

            @if (!empty($groupSettings['group_tagline']))
                <p class="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10" data-reveal
                    style="transition-delay:160ms">
                    {{ $groupSettings['group_tagline'] }}
                </p>
            @endif

            <div class="flex flex-wrap items-center justify-center gap-4" data-reveal style="transition-delay:240ms">
                <x-button variant="accent" href="{{ route('companies.index') }}">
                    Explore Our Services
                </x-button>
                <x-button variant="outline-light" href="{{ route('contact') }}">
                    Contact Us
                </x-button>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
    </section>

    {{-- About --}}
    @if (!empty($groupSettings['group_bio']))
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <div class="grid lg:grid-cols-3 gap-12 lg:items-center">
                <div class="lg:col-span-1">
                    <x-section-heading eyebrow="About Us">
                        {{ $groupSettings['group_name'] ?? config('app.name') }}
                    </x-section-heading>

                    <dl class="mt-10 space-y-6" data-reveal style="transition-delay:60ms">
                        @foreach ([
                            ['icon' => 'check', 'title' => 'Perusahaan Induk', 'desc' => 'PT Susanto Group menaungi unit-unit usaha di bawah bendera AMT Group.'],
                            ['icon' => 'check', 'title' => 'Akar di Industri Ban', 'desc' => 'Distribusi ban truck dan layanan vulkanisir ban metode dingin.'],
                            ['icon' => 'map-pin', 'title' => 'Jaringan Nasional', 'desc' => 'Melayani pelanggan di berbagai wilayah Indonesia.'],
                        ] as $fact)
                            <div class="flex items-start gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                                    <x-icon name="{{ $fact['icon'] }}" class="h-5 w-5" />
                                </span>
                                <div>
                                    <dt class="font-display font-semibold text-slate-900">{{ $fact['title'] }}</dt>
                                    <dd class="text-sm text-slate-500 mt-0.5">{{ $fact['desc'] }}</dd>
                                </div>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="lg:col-span-2 prose prose-slate max-w-none prose-p:leading-relaxed prose-p:text-slate-600 [&>p:first-of-type]:text-lg [&>p:first-of-type]:font-medium [&>p:first-of-type]:text-slate-800 prose-headings:font-display prose-headings:font-semibold prose-strong:text-slate-900 prose-a:text-brand-600"
                    data-reveal style="transition-delay:120ms">
                    {!! $groupSettings['group_bio'] !!}
                </div>
            </div>
        </section>
    @endif

    {{-- Company Profile --}}
    <section class="py-20 sm:py-28 border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Company Profile" class="mb-12">
                Legalitas Perusahaan
            </x-section-heading>

            @php
                // Holding-level legality. Each subsidiary's own profile lives on its
                // Our Services page (see the Company records), not here.
                $companyProfile = [
                    'Identitas' => 'PT Susanto Group',
                    'Tahun Berdiri' => '2025',
                    'Pendiri' => 'Agus Susanto',
                    'Bentuk Usaha' => 'PT (holding)',
                    'Media Sosial' => 'AMT Group Official',
                ];

                $ownerPhotos = collect([
                    'owners/agus-susanto-1.png',
                    'owners/agus-susanto-2.png',
                    'owners/agus-susanto-3.png',
                    'owners/agus-susanto-4.png',
                ])->filter(fn ($path) => \Illuminate\Support\Facades\Storage::disk('public')->exists($path))->values();
            @endphp

            {{-- A handful of short facts reads better as a row of tiles than as a
            wide table, which left most of its rows empty. --}}
            <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5" data-reveal>
                @foreach ($companyProfile as $label => $value)
                    <div class="rounded-2xl border border-slate-200 bg-white px-5 py-5">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $label }}</dt>
                        <dd class="font-display font-semibold text-slate-900 mt-2">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>

            <div class="mt-8 grid sm:grid-cols-3 overflow-hidden rounded-2xl bg-slate-900 text-white" data-reveal
                style="transition-delay:100ms">
                @if ($ownerPhotos->isNotEmpty())
                    <div class="relative aspect-[4/5] bg-slate-800 sm:aspect-auto sm:min-h-[20rem]"
                        x-data="{ active: 0 }"
                        x-init="setInterval(() => active = (active + 1) % {{ $ownerPhotos->count() }}, 5000)">
                        @foreach ($ownerPhotos as $index => $photo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($photo) }}" alt="Agus Susanto"
                                x-show="active === {{ $index }}"
                                x-transition:enter="transition ease-out duration-700"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-700"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="absolute inset-0 h-full w-full object-cover object-top">
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-col justify-center p-8 sm:p-10 {{ $ownerPhotos->isNotEmpty() ? 'sm:col-span-2' : 'sm:col-span-3' }}">
                    @if ($ownerPhotos->isNotEmpty())
                        <div class="font-display font-semibold text-white">Agus Susanto</div>
                        <div class="text-xs text-brand-400 uppercase tracking-wide font-semibold mb-6">Pendiri, PT Susanto Group</div>
                    @else
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500/15 text-brand-400 mb-5">
                            <x-icon name="check" class="h-5 w-5" />
                        </span>
                    @endif
                    <h3 class="font-display text-lg font-semibold mb-3">Komitmen Perusahaan</h3>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-2xl">
                        Sebagai perusahaan induk, AMT Group berkomitmen mengembangkan setiap unit usaha yang
                        dinaunginya melalui tata kelola yang rapi, peningkatan kualitas produk dan layanan, serta
                        perluasan jaringan distribusi. Fokus kami adalah menjadi mitra yang dapat diandalkan bagi
                        pelanggan di seluruh Indonesia.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Portfolio --}}
    <section class="bg-slate-50 py-20 sm:py-28">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-6 mb-12">
                <x-section-heading eyebrow="Our Portfolio">
                    Companies under {{ $groupSettings['group_name'] ?? config('app.name') }}
                </x-section-heading>

                <x-button variant="outline" href="{{ route('companies.index') }}">View All Services</x-button>
            </div>

            @if (!empty($groupSettings['group_portfolio_intro']))
                <p class="text-slate-500 max-w-2xl mb-10 -mt-6" data-reveal>
                    {{ $groupSettings['group_portfolio_intro'] }}</p>
            @endif

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
                @foreach ($activeCompanies ?? [] as $company)
                    <a href="{{ route('companies.show', $company) }}"
                        class="group block rounded-2xl bg-white border border-slate-200 p-6 hover:border-brand-300 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                        @if ($company->logo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($company->logo) }}"
                                alt="{{ $company->name }}" class="h-12 w-auto mb-5 object-contain">
                        @else
                            <span
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-900 text-brand-400 font-display text-lg mb-5">
                                {{ mb_substr($company->name, 0, 1) }}
                            </span>
                        @endif
                        <div
                            class="font-display font-semibold text-slate-900 mb-2 group-hover:text-brand-600 transition-colors">
                            {{ $company->name }}</div>
                        <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed">
                            {{ str($company->bio)->stripTags()->limit(120) }}</p>
                        <span
                            class="inline-flex items-center gap-1 text-sm font-medium text-brand-600 mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            Learn more <span aria-hidden="true">&rarr;</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Latest Articles --}}
    @if (($latestArticles ?? collect())->isNotEmpty())
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <div class="flex flex-wrap items-end justify-between gap-6 mb-12">
                <x-section-heading eyebrow="News & Artikel">
                    Latest from {{ $groupSettings['group_name'] ?? config('app.name') }}
                </x-section-heading>
                <x-button variant="outline" href="{{ route('articles.index') }}">View All Articles</x-button>
            </div>

            <div class="grid gap-6 sm:grid-cols-3" data-reveal-group>
                @foreach ($latestArticles as $article)
                    <a href="{{ route('articles.show', $article) }}"
                        class="group block rounded-2xl overflow-hidden border border-slate-200 hover:border-brand-300 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                        <div class="overflow-hidden">
                            @if ($article->featured_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}"
                                    alt="{{ $article->featured_image_alt ?: $article->title }}" loading="lazy"
                                    class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-44 bg-slate-100"></div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div
                                class="font-display font-semibold text-slate-900 mb-1.5 group-hover:text-brand-600 transition-colors">
                                {{ $article->title }}</div>
                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ $article->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA banner --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 sm:pb-28">
        <div class="relative overflow-hidden rounded-3xl bg-slate-900 px-8 sm:px-16 py-16 text-center" data-reveal>
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 50% 0%, rgba(245,158,11,0.15), transparent 55%);">
            </div>
            <div class="relative">
                <h2 class="font-display text-2xl sm:text-3xl font-bold text-white mb-4">Let's work together</h2>
                <p class="text-slate-400 max-w-xl mx-auto mb-8">Have a question about our companies or products? Reach
                    out and our team will get back to you.</p>
                <x-button variant="accent" href="{{ route('contact') }}">Get in Touch</x-button>
            </div>
        </div>
    </section>

</x-public-layout>
