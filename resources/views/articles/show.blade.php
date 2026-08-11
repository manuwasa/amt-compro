@php($title = $article->metaTitle())
@php($description = $article->metaDescription())
@php($image = $article->featured_image)

<x-public-layout :title="$title" :description="$description" :image="$image" ogType="article">

    @push('jsonld')
        <script type="application/ld+json">
            {!! json_encode(array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $article->title,
                'image' => $article->featured_image ? \Illuminate\Support\Facades\Storage::url($article->featured_image) : null,
                'datePublished' => $article->published_at?->toIso8601String(),
                'dateModified' => $article->updated_at?->toIso8601String(),
                'author' => $article->author ? ['@type' => 'Person', 'name' => $article->author->name] : null,
                'mainEntityOfPage' => route('articles.show', $article),
            ]), JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endpush

    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16" data-reveal>
        <x-breadcrumbs class="mb-6" :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'News & Artikel', 'url' => route('articles.index')],
            ['label' => $article->title, 'url' => null],
        ]" />

        @if ($article->category)
            <div class="text-xs font-semibold uppercase tracking-wide text-brand-600 mb-3">{{ $article->category }}</div>
        @endif

        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-slate-900 mb-4">{{ $article->title }}</h1>

        <time class="block mb-8 text-sm text-slate-400" datetime="{{ $article->published_at?->toDateString() }}">{{ $article->published_at?->format('d M Y') }}</time>

        @if ($article->featured_image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" alt="{{ $article->featured_image_alt ?: $article->title }}" class="w-full rounded-2xl mb-10 object-cover">
        @endif

        <div class="prose prose-slate max-w-none prose-headings:font-display prose-headings:font-semibold prose-a:text-brand-600">
            {!! $article->content !!}
        </div>

        @if (! empty($article->tagList()))
            <div class="mt-10 flex flex-wrap gap-2 text-xs text-slate-500">
                @foreach ($article->tagList() as $tag)
                    <span class="px-3 py-1.5 rounded-full bg-slate-100">#{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </article>

    @if ($relatedArticles->isNotEmpty())
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20 border-t border-slate-100 pt-12">
            <h2 class="font-display text-xl font-bold text-slate-900 mb-8" data-reveal>Related Articles</h2>
            <div class="grid gap-6 sm:grid-cols-3" data-reveal-group>
                @foreach ($relatedArticles as $related)
                    <a href="{{ route('articles.show', $related) }}" class="group block rounded-2xl overflow-hidden border border-slate-200 hover:border-brand-300 hover:shadow-lg hover:shadow-slate-200/60 hover:-translate-y-1 transition-all duration-300">
                        <div class="overflow-hidden bg-slate-50">
                            @if ($related->featured_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($related->featured_image) }}" alt="{{ $related->featured_image_alt ?: $related->title }}" loading="lazy" class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                        </div>
                        <div class="p-3 font-medium text-sm text-slate-900 group-hover:text-brand-600 transition-colors">{{ $related->title }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</x-public-layout>
