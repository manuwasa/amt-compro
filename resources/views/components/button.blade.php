@props(['variant' => 'primary', 'href' => null, 'type' => null])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-full px-6 py-3 text-sm font-semibold transition-all duration-300 ease-out';

    $variants = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-slate-900/20 active:translate-y-0',
        'accent' => 'bg-brand-500 text-slate-900 hover:bg-brand-400 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand-500/30 active:translate-y-0',
        'outline' => 'border border-slate-300 text-slate-700 hover:border-slate-900 hover:text-slate-900',
        'outline-light' => 'border border-white/30 text-white hover:border-white hover:bg-white/10',
        'ghost' => 'text-slate-600 hover:text-slate-900',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type ?? 'button' }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
