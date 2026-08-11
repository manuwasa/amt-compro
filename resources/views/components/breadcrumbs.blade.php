@props(['items' => [], 'dark' => false])

@php
    // $items: array of ['label' => string, 'url' => string|null]. Last item (current page) should have url => null.
    $jsonLdItems = collect($items)->values()->map(fn ($item, $index) => array_filter([
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $item['label'],
        'item' => $item['url'] ?? null,
    ]))->all();

    $mutedText = $dark ? 'text-slate-400' : 'text-slate-500';
    $hoverText = $dark ? 'hover:text-white' : 'hover:text-slate-900';
    $currentText = $dark ? 'text-slate-200' : 'text-slate-700';
@endphp

@if (count($items))
    <nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => "text-sm $mutedText"]) }}>
        <ol class="flex flex-wrap items-center gap-1.5">
            @foreach ($items as $index => $item)
                <li class="flex items-center gap-1.5">
                    @if (! empty($item['url']))
                        <a href="{{ $item['url'] }}" class="{{ $hoverText }} transition-colors">{{ $item['label'] }}</a>
                    @else
                        <span class="{{ $currentText }}" aria-current="page">{{ $item['label'] }}</span>
                    @endif
                    @if ($index < count($items) - 1)
                        <span aria-hidden="true" class="opacity-50">/</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $jsonLdItems,
        ]) !!}
    </script>
@endif
