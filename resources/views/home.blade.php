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
            <div class="grid lg:grid-cols-3 gap-12">
                <div class="lg:col-span-1">
                    <x-section-heading eyebrow="About Us">
                        CV AMT Jaya Ban
                    </x-section-heading>

                    <dl class="mt-10 space-y-6" data-reveal style="transition-delay:60ms">
                        @foreach ([
                            ['icon' => 'check', 'title' => 'Sejak 2007', 'desc' => 'Dari toko kecil hingga distributor dan produsen vulkanisir ban truck.'],
                            ['icon' => 'map-pin', 'title' => 'Jaringan 4 Wilayah', 'desc' => 'Cibitung, Rembang, Kalimantan, dan Sulawesi.'],
                            ['icon' => 'check', 'title' => 'Spesialis Cold Retread', 'desc' => 'Vulkanisir ban metode dingin untuk kualitas premium.'],
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
                Identitas Perusahaan
            </x-section-heading>

            @php
                $companyProfile = [
                    'Nama Perusahaan' => 'CV AMT Jaya Ban',
                    'Tahun Berdiri' => '2007',
                    'Pendiri' => 'Agus Susanto',
                    'Bentuk Usaha' => 'Commanditaire Vennootschap (CV)',
                    'Lokasi Kantor' => 'Cibitung',
                    'Bidang Usaha' => 'Otomotif – Distribusi Ban Truck dan Vulkanisir Ban',
                    'Produk Utama' => 'Distributor Ban Truck',
                    'Layanan Unggulan' => 'Vulkanisir Ban dengan Metode Dingin',
                    'Target Pelanggan' => 'Armada pertambangan dan pengguna truck',
                    'Wilayah Distribusi' => 'Seluruh Indonesia',
                    'Jaringan Operasional' => 'Cibitung, Rembang, Kalimantan, dan Sulawesi',
                    'Kegiatan Perdagangan' => 'Distribusi dan impor ban dari China',
                    'Media Sosial' => 'AMT Group Official',
                ];

                $ownerPhotos = collect([
                    'owners/agus-susanto-1.png',
                    'owners/agus-susanto-2.png',
                    'owners/agus-susanto-3.png',
                    'owners/agus-susanto-4.png',
                ])->filter(fn ($path) => \Illuminate\Support\Facades\Storage::disk('public')->exists($path))->values();
            @endphp

            <div class="grid lg:grid-cols-3 gap-8 items-stretch">
                <dl class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white divide-y divide-slate-100 overflow-hidden"
                    data-reveal>
                    @foreach ($companyProfile as $label => $value)
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-6 px-6 py-4">
                            <dt class="text-sm font-semibold text-slate-500">{{ $label }}</dt>
                            <dd class="sm:col-span-2 text-sm text-slate-900">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>

                <div class="rounded-2xl bg-slate-900 p-8 text-white flex flex-col" data-reveal style="transition-delay:100ms">
                    @if ($ownerPhotos->isNotEmpty())
                        <div class="relative w-full aspect-[5/4] rounded-xl overflow-hidden bg-slate-800 mb-4"
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
                        <div class="font-display font-semibold text-white">Agus Susanto</div>
                        <div class="text-xs text-brand-400 uppercase tracking-wide font-semibold mb-5">Pendiri, CV AMT Jaya Ban</div>
                    @else
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500/15 text-brand-400 mb-5">
                            <x-icon name="check" class="h-5 w-5" />
                        </span>
                    @endif
                    <h3 class="font-display text-lg font-semibold mb-3">Komitmen Perusahaan</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        CV AMT Jaya Ban berkomitmen untuk terus mengembangkan kualitas produk, kapasitas produksi,
                        jaringan distribusi, serta pelayanan purna jual. Dengan pengalaman sejak 2007 dan jaringan
                        yang terus berkembang, perusahaan berupaya menjadi mitra yang dapat diandalkan bagi pelanggan
                        dalam memenuhi kebutuhan ban truck dan solusi vulkanisir di Indonesia.
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
