@php($title = 'Products')
@php($description = 'Product catalog from ' . ($groupSettings['group_name'] ?? config('app.name')) . ' companies.')

<x-public-layout :title="$title" :description="$description">

    <section class="bg-slate-900 py-16 sm:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs dark :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Products', 'url' => null],
            ]" />

            <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-white mt-4" data-reveal>Products</h1>
            <p class="text-slate-400 mt-3 max-w-2xl" data-reveal style="transition-delay:80ms">Browse the catalog across all {{ $groupSettings['group_name'] ?? config('app.name') }} companies.</p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="flex flex-wrap gap-2 mb-10 text-sm">
            <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-full border font-medium transition-colors {{ ! request('company') ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-200 text-slate-500 hover:border-slate-400' }}">All</a>
            @foreach ($companies as $company)
                <a href="{{ route('products.index', ['company' => $company->slug]) }}" class="px-4 py-2 rounded-full border font-medium transition-colors {{ request('company') === $company->slug ? 'bg-slate-900 text-white border-slate-900' : 'border-slate-200 text-slate-500 hover:border-slate-400' }}">{{ $company->name }}</a>
            @endforeach
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group block rounded-2xl overflow-hidden border border-slate-200 hover:border-brand-300 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                    <div class="overflow-hidden bg-slate-50">
                        @if ($product->image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-40"></div>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="text-xs uppercase tracking-wide text-slate-400 mb-1">{{ $product->company->name ?? ($groupSettings['group_name'] ?? 'AMT Group') }}</div>
                        @if ($product->brand)
                            <div class="text-xs text-slate-400 mb-1">{{ $product->brand }}</div>
                        @endif
                        <div class="font-semibold text-slate-900 group-hover:text-brand-600 transition-colors">{{ $product->name }}</div>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($products->isEmpty())
            <p class="text-slate-500">No products published yet.</p>
        @endif

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>

</x-public-layout>
