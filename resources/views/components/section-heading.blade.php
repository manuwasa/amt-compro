@props(['eyebrow' => null, 'align' => 'left'])

<div {{ $attributes->merge(['class' => ($align === 'center' ? 'text-center mx-auto' : '').' max-w-2xl']) }} data-reveal>
    @if ($eyebrow)
        <p class="text-sm font-semibold uppercase tracking-wider text-brand-600 mb-3">{{ $eyebrow }}</p>
    @endif

    <h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
        {{ $slot }}
    </h2>
</div>
