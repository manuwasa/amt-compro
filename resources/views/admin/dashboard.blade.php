<x-admin-layout title="Dashboard">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.companies.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 hover:border-brand-300 hover:shadow-md hover:shadow-slate-200/60 transition-all duration-300">
            <div class="text-sm text-slate-500 mb-1">Companies</div>
            <div class="text-3xl font-display font-bold text-slate-900">{{ $companiesCount }}</div>
        </a>
        <a href="{{ route('admin.products.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 hover:border-brand-300 hover:shadow-md hover:shadow-slate-200/60 transition-all duration-300">
            <div class="text-sm text-slate-500 mb-1">Products</div>
            <div class="text-3xl font-display font-bold text-slate-900">{{ $productsCount }}</div>
        </a>
        <a href="{{ route('admin.articles.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 hover:border-brand-300 hover:shadow-md hover:shadow-slate-200/60 transition-all duration-300">
            <div class="text-sm text-slate-500 mb-1">Articles</div>
            <div class="text-3xl font-display font-bold text-slate-900">{{ $articlesCount }}</div>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 hover:border-brand-300 hover:shadow-md hover:shadow-slate-200/60 transition-all duration-300">
            <div class="text-sm text-slate-500 mb-1">Unread Messages</div>
            <div class="text-3xl font-display font-bold {{ $unreadMessagesCount > 0 ? 'text-brand-600' : 'text-slate-900' }}">{{ $unreadMessagesCount }}</div>
        </a>
    </div>
</x-admin-layout>
