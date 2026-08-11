@php($title = $product->metaTitle())
@php($description = $product->metaDescription())
@php($image = $product->image)

<x-public-layout :title="$title" :description="$description" :image="$image" ogType="product">

    @push('jsonld')
        <script type="application/ld+json">
            {!! json_encode(array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $product->name,
                'brand' => $product->brand,
                'category' => $product->category,
                'description' => $product->description,
                'image' => $product->image ? \Illuminate\Support\Facades\Storage::url($product->image) : null,
                'url' => route('products.show', $product),
            ]), JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <x-breadcrumbs class="mb-8" :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Products', 'url' => route('products.index')],
            ['label' => $product->name, 'url' => null],
        ]" />

        <div class="grid gap-12 lg:grid-cols-2" data-reveal>
            @php($primaryImageUrl = $product->image ? \Illuminate\Support\Facades\Storage::url($product->image) : null)
            @php($galleryImageUrls = collect($product->gallery ?? [])->map(fn ($path) => \Illuminate\Support\Facades\Storage::url($path)))
            @php($allImageUrls = collect([$primaryImageUrl])->merge($galleryImageUrls)->filter()->values())

            <div x-data="{ active: @js($allImageUrls->first()) }">
                <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                    @if ($allImageUrls->isNotEmpty())
                        <img :src="active" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                    @else
                        <div class="w-full aspect-square"></div>
                    @endif
                </div>

                @if ($allImageUrls->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach ($allImageUrls as $url)
                            <button
                                type="button"
                                @click="active = @js($url)"
                                :class="active === @js($url) ? 'border-brand-500 ring-2 ring-brand-500/30' : 'border-slate-200 hover:border-brand-300'"
                                class="rounded-xl overflow-hidden border-2 transition-colors"
                            >
                                <img src="{{ $url }}" alt="{{ $product->name }}" loading="lazy" class="w-full aspect-square object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                @if ($product->brand)
                    <div class="inline-flex items-center rounded-full bg-brand-50 text-brand-700 text-xs font-semibold uppercase tracking-wide px-3 py-1 mb-4">{{ $product->brand }}</div>
                @endif
                <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-slate-900 mb-5">{{ $product->name }}</h1>

                <p class="text-slate-600 leading-relaxed mb-8">{{ $product->description }}</p>

                @if ($product->company)
                    <a href="{{ route('companies.show', $product->company) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors">
                        From {{ $product->company->name }} <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                @else
                    <span class="inline-flex items-center text-sm font-medium text-slate-500">
                        Distributed by {{ $groupSettings['group_name'] ?? 'AMT Group' }}
                    </span>
                @endif

                <div class="mt-8">
                    <x-button variant="primary" :href="route('contact', ['subject' => 'Inquiry about '.$product->name])">
                        Contact Us About This Product <x-icon name="arrow-right" class="h-4 w-4" />
                    </x-button>
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-20">
                <h2 class="font-display text-xl font-bold text-slate-900 mb-8" data-reveal>{{ $product->company ? 'More from '.$product->company->name : 'More '.($groupSettings['group_name'] ?? 'AMT Group').' Products' }}</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
                    @foreach ($relatedProducts as $related)
                        <a href="{{ route('products.show', $related) }}" class="group block rounded-2xl overflow-hidden border border-slate-200 hover:border-brand-300 hover:shadow-lg hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                            <div class="overflow-hidden bg-slate-50">
                                @if ($related->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($related->image) }}" alt="{{ $related->name }}" loading="lazy" class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-32"></div>
                                @endif
                            </div>
                            <div class="p-3 font-medium text-sm text-slate-900 group-hover:text-brand-600 transition-colors">{{ $related->name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</x-public-layout>
