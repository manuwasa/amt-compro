@php($title = 'Our Services')
@php($description = 'Companies under ' . ($groupSettings['group_name'] ?? config('app.name')) . '.')

<x-public-layout :title="$title" :description="$description">

    <section class="bg-slate-900 py-16 sm:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs dark :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Our Services', 'url' => null],
            ]" />

            <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-white mt-4" data-reveal>Our Services</h1>
            <p class="text-slate-400 mt-3 max-w-2xl" data-reveal style="transition-delay:80ms">The companies that make up {{ $groupSettings['group_name'] ?? config('app.name') }}.</p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach ($companies as $company)
                <a href="{{ route('companies.show', $company) }}" class="group block rounded-2xl bg-white border border-slate-200 p-7 hover:border-brand-300 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                    @if ($company->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($company->logo) }}" alt="{{ $company->name }}" class="h-12 w-auto mb-5 object-contain">
                    @else
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-900 text-brand-400 font-display text-lg mb-5">
                            {{ mb_substr($company->name, 0, 1) }}
                        </span>
                    @endif
                    <div class="font-display font-semibold text-lg text-slate-900 mb-2 group-hover:text-brand-600 transition-colors">{{ $company->name }}</div>
                    <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed">{{ str($company->bio)->stripTags()->limit(140) }}</p>
                    <span class="inline-flex items-center gap-1 text-sm font-medium text-brand-600 mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        View profile <span aria-hidden="true">&rarr;</span>
                    </span>
                </a>
            @endforeach
        </div>

        @if ($companies->isEmpty())
            <p class="text-slate-500">No companies published yet.</p>
        @endif
    </div>

</x-public-layout>
