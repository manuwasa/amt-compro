<x-admin-layout title="New User">
    <form method="POST" action="{{ route('admin.users.store') }}" class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        @include('admin.users._form')
    </form>
</x-admin-layout>
