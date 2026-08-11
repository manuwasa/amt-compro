<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $groupSettings['group_name'] ?? config('app.name') }}</title>

        <script>document.documentElement.classList.add('reveal-ready')</script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 bg-slate-50" style="background-image: radial-gradient(circle at top, rgba(245,158,11,0.08), transparent 55%);">
            <div class="w-full max-w-md" data-reveal>
                <div class="flex justify-center mb-8">
                    <a href="/" class="flex items-center gap-2.5 font-display font-bold text-lg text-slate-900">
                        @if (! empty($groupSettings['group_logo']))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($groupSettings['group_logo']) }}" alt="{{ $groupSettings['group_name'] ?? config('app.name') }}" class="h-10 w-auto">
                        @else
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-brand-400 text-base">
                                {{ mb_substr($groupSettings['group_name'] ?? config('app.name'), 0, 1) }}
                            </span>
                        @endif
                        <span>{{ $groupSettings['group_name'] ?? config('app.name') }}</span>
                    </a>
                </div>

                <div class="bg-white shadow-xl shadow-slate-200/60 ring-1 ring-slate-900/5 rounded-2xl px-6 py-8 sm:px-8">
                    {{ $slot }}
                </div>

                <p class="text-center text-xs text-slate-400 mt-8">
                    &copy; {{ date('Y') }} {{ $groupSettings['group_name'] ?? config('app.name') }}
                </p>
            </div>
        </div>
    </body>
</html>
