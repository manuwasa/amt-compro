<x-admin-layout title="New Article">
    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="max-w-6xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        @include('admin.articles._form')
    </form>
</x-admin-layout>
