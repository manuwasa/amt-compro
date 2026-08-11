@php($title = 'News & Artikel')
@php($description = 'Latest news and articles from ' . ($groupSettings['group_name'] ?? config('app.name')) . '.')

<x-public-layout :title="$title" :description="$description">

    <section class="bg-slate-900 py-16 sm:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs dark :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'News & Artikel', 'url' => null],
            ]" />

            <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-white mt-4" data-reveal>News &amp; Artikel</h1>
            <p class="text-slate-400 mt-3 max-w-2xl" data-reveal style="transition-delay:80ms">Updates, tips, and news from {{ $groupSettings['group_name'] ?? config('app.name') }}.</p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
            @foreach ($articles as $article)
                <a href="{{ route('articles.show', $article) }}" class="group block rounded-2xl overflow-hidden border border-slate-200 hover:border-brand-300 hover:shadow-xl hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                    <div class="overflow-hidden bg-slate-50">
                        @if ($article->featured_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" alt="{{ $article->featured_image_alt ?: $article->title }}" loading="lazy" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-44"></div>
                        @endif
                    </div>
                    <div class="p-5">
                        @if ($article->category)
                            <div class="text-xs font-semibold uppercase tracking-wide text-brand-600 mb-2">{{ $article->category }}</div>
                        @endif
                        <div class="font-display font-semibold text-slate-900 mb-2 group-hover:text-brand-600 transition-colors">{{ $article->title }}</div>
                        <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed mb-3">{{ $article->excerpt }}</p>
                        <time class="block text-xs text-slate-400" datetime="{{ $article->published_at?->toDateString() }}">{{ $article->published_at?->format('d M Y') }}</time>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($articles->isEmpty())
            <p class="text-slate-500">No articles published yet.</p>
        @endif

        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    </div>

</x-public-layout>
