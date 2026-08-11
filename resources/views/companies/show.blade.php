@php($title = $company->metaTitle())
@php($description = $company->metaDescription())
@php($image = $company->cover_image ?: $company->logo)

<x-public-layout :title="$title" :description="$description" :image="$image" ogType="business.business">

    @push('jsonld')
        <script type="application/ld+json">
            {!! json_encode(array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                'name' => $company->name,
                'url' => route('companies.show', $company),
                'logo' => $company->logo ? \Illuminate\Support\Facades\Storage::url($company->logo) : null,
                'address' => $company->address,
                'telephone' => $company->phone,
                'email' => $company->email,
            ]), JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    <section class="relative bg-slate-900 py-16 sm:py-20 overflow-hidden">
        @if ($company->cover_image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($company->cover_image) }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/80 to-slate-900/20"></div>
        @endif

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs dark :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Our Services', 'url' => route('companies.index')],
                ['label' => $company->name, 'url' => null],
            ]" />

            <div class="flex items-center gap-4 mt-5" data-reveal>
                @if ($company->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($company->logo) }}" alt="{{ $company->name }}" class="h-16 w-16 rounded-2xl bg-white object-contain p-2">
                @else
                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 text-brand-400 font-display text-2xl">
                        {{ mb_substr($company->name, 0, 1) }}
                    </span>
                @endif
                <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-white">{{ $company->name }}</h1>
            </div>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="grid gap-10 lg:grid-cols-3">
            <div class="lg:col-span-2 prose prose-slate max-w-none prose-headings:font-display prose-headings:font-semibold prose-a:text-brand-600" data-reveal>
                {!! $company->bio !!}
            </div>

            <aside class="rounded-2xl bg-slate-50 border border-slate-200 p-6 text-sm space-y-4 self-start" data-reveal style="transition-delay:100ms">
                <div class="font-display font-semibold text-slate-900">Contact {{ $company->name }}</div>

                @if ($company->address)
                    <div class="flex gap-3">
                        <x-icon name="map-pin" class="h-5 w-5 text-brand-600 shrink-0 mt-0.5" />
                        <p class="text-slate-500 leading-relaxed">{{ $company->address }}</p>
                    </div>
                @endif
                @if ($company->phone)
                    <div class="flex gap-3">
                        <x-icon name="phone" class="h-5 w-5 text-brand-600 shrink-0" />
                        <a href="tel:{{ $company->phone }}" class="text-slate-600 hover:text-slate-900 transition-colors">{{ $company->phone }}</a>
                    </div>
                @endif
                @if ($company->email)
                    <div class="flex gap-3">
                        <x-icon name="envelope" class="h-5 w-5 text-brand-600 shrink-0" />
                        <a href="mailto:{{ $company->email }}" class="text-slate-600 hover:text-slate-900 transition-colors break-all">{{ $company->email }}</a>
                    </div>
                @endif
                @if ($company->whatsappUrl())
                    <div class="flex gap-3">
                        <x-icon name="chat" class="h-5 w-5 text-brand-600 shrink-0" />
                        <a href="{{ $company->whatsappUrl() }}" target="_blank" rel="noopener" class="text-slate-600 hover:text-slate-900 transition-colors">Chat on WhatsApp</a>
                    </div>
                @endif
            </aside>
        </div>

        @if ($products->isNotEmpty())
            <div class="mt-20">
                <h2 class="font-display text-2xl font-bold text-slate-900 mb-8" data-reveal>Products</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="group block rounded-2xl overflow-hidden border border-slate-200 hover:border-brand-300 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                            <div class="overflow-hidden bg-slate-50">
                                @if ($product->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-36"></div>
                                @endif
                            </div>
                            <div class="p-4">
                                @if ($product->brand)
                                    <div class="text-xs uppercase tracking-wide text-slate-400 mb-1">{{ $product->brand }}</div>
                                @endif
                                <div class="font-semibold text-slate-900 group-hover:text-brand-600 transition-colors">{{ $product->name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</x-public-layout>
