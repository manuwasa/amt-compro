@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} — Admin — {{ $groupSettings['group_name'] ?? config('app.name') }}</title>

    <script>document.documentElement.classList.add('reveal-ready')</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased font-sans" x-data="{ sidebarOpen: false }">

    @php
        $navItems = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
            ['label' => 'Companies', 'route' => 'admin.companies.index', 'active' => 'admin.companies.*'],
            ['label' => 'Products', 'route' => 'admin.products.index', 'active' => 'admin.products.*'],
            ['label' => 'Articles', 'route' => 'admin.articles.index', 'active' => 'admin.articles.*'],
            ['label' => 'Messages', 'route' => 'admin.messages.index', 'active' => 'admin.messages.*'],
        ];
    @endphp

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"></div>

    <div class="flex min-h-screen">
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 shrink-0 bg-slate-900 text-slate-300 flex flex-col transform transition-transform duration-300 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="h-16 flex items-center px-6 gap-2.5 text-white font-display font-bold shrink-0">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-500 text-slate-900 text-sm">
                    {{ mb_substr($groupSettings['group_name'] ?? config('app.name'), 0, 1) }}
                </span>
                <span class="truncate">{{ $groupSettings['group_name'] ?? config('app.name') }}</span>
            </div>

            <nav class="flex-1 px-3 space-y-0.5 text-sm overflow-y-auto">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}" class="block rounded-lg px-3.5 py-2.5 border-l-2 transition-colors {{ request()->routeIs($item['active']) ? 'border-brand-500 bg-white/5 text-white' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach

                @if (auth()->user()?->isSuperAdmin())
                    <div class="pt-5 mt-4 border-t border-white/10 text-xs font-semibold uppercase tracking-wider text-slate-500 px-3.5 pb-1">Superadmin</div>
                    <a href="{{ route('admin.settings.edit') }}" class="block rounded-lg px-3.5 py-2.5 border-l-2 transition-colors {{ request()->routeIs('admin.settings.*') ? 'border-brand-500 bg-white/5 text-white' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }}">Group Settings</a>
                    <a href="{{ route('admin.users.index') }}" class="block rounded-lg px-3.5 py-2.5 border-l-2 transition-colors {{ request()->routeIs('admin.users.*') ? 'border-brand-500 bg-white/5 text-white' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-white' }}">Users</a>
                @endif
            </nav>

            <div class="p-3 border-t border-white/10 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2 rounded-lg px-3.5 py-2.5 text-sm text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                    <span aria-hidden="true">&larr;</span> Back to site
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 shrink-0">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" type="button" class="lg:hidden -ml-1 p-2 rounded-lg text-slate-500 hover:bg-slate-100" aria-label="Open menu">
                        <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold tracking-tight">{{ $title }}</h1>
                </div>

                <div class="flex items-center gap-3 text-sm">
                    <div class="hidden sm:flex items-center gap-2.5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white text-xs font-semibold">
                            {{ mb_substr(auth()->user()?->name ?? '?', 0, 1) }}
                        </span>
                        <div class="leading-tight">
                            <div class="font-medium text-slate-900">{{ auth()->user()?->name }}</div>
                            <div class="text-xs text-slate-400 capitalize">{{ auth()->user()?->role }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg px-3 py-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">Log out</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                @if (session('status'))
                    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
