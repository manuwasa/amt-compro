<x-admin-layout title="New Company">
    <form method="POST" action="{{ route('admin.companies.store') }}" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        @include('admin.companies._form')
    </form>
</x-admin-layout>
