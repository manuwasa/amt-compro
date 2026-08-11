<x-admin-layout title="Articles">
    <p class="text-sm text-slate-500 mb-4">Posts shown under "News &amp; Artikel" on the public site.</p>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <x-admin-search placeholder="Search articles..." />
        <x-button variant="primary" href="{{ route('admin.articles.create') }}">New Article</x-button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500 text-xs font-semibold uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-3.5">Title</th>
                    <th class="px-5 py-3.5">Category</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5">Published</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($articles as $article)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $article->title }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $article->category }}</td>
                        <td class="px-5 py-4">
                            @if ($article->is_published)
                                <span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2.5 py-1 text-xs font-medium">Published</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 text-slate-500 px-2.5 py-1 text-xs font-medium">Draft</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ $article->published_at?->format('d M Y') }}</td>
                        <td class="px-5 py-4 text-right space-x-4">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-slate-500 hover:text-slate-900 hover:underline transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" class="inline" onsubmit="return confirm('Delete {{ $article->title }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 hover:underline transition-colors">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($articles->isEmpty())
        <p class="text-slate-500 mt-4">No articles found.</p>
    @endif

    <div class="mt-6">
        {{ $articles->links() }}
    </div>
</x-admin-layout>
