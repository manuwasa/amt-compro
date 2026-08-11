<x-admin-layout title="Edit Article">
    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="max-w-6xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        @method('PUT')
        @include('admin.articles._form')
    </form>
</x-admin-layout>
