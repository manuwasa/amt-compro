<x-admin-layout title="Edit Company">
    <form method="POST" action="{{ route('admin.companies.update', $company) }}" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        @method('PUT')
        @include('admin.companies._form')
    </form>

    <div class="max-w-3xl mx-auto mt-4">
        <a href="{{ route('admin.products.index', ['company' => $company->slug]) }}" class="text-sm font-medium text-slate-500 hover:text-brand-600 transition-colors">Manage {{ $company->name }}'s products &rarr;</a>
    </div>
</x-admin-layout>
