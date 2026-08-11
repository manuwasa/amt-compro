@php($title = 'Session Expired')

<x-public-layout :title="$title">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-28 sm:py-36 text-center" data-reveal>
        <div class="font-display text-7xl font-bold text-brand-500 mb-4">419</div>
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-slate-900 mb-4">Session Expired</h1>
        <p class="text-slate-500 mb-10">Your session timed out. Please go back and try again.</p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <x-button variant="primary" href="javascript:history.back()">Go Back</x-button>
            <x-button variant="outline" href="{{ route('home') }}">Go Home</x-button>
        </div>
    </div>
</x-public-layout>
