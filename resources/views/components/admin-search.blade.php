@props(['placeholder' => 'Search...'])

<form method="GET" class="flex items-center gap-2">
    @foreach (request()->except(['search', 'page']) as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <div class="relative">
        <x-icon name="search" class="h-4 w-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}" class="w-full sm:w-64 rounded-lg border-slate-300 shadow-sm pl-9 focus:border-brand-500 focus:ring-brand-500 transition-colors text-sm">
    </div>

    @if (request('search'))
        <a href="{{ request()->fullUrlWithoutQuery(['search', 'page']) }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors">Clear</a>
    @endif
</form>
