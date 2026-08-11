<x-admin-layout :title="'Edit Product — ' . $product->name">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        @method('PUT')
        @include('admin.products._form')
    </form>
</x-admin-layout>
