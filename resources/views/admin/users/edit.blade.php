<x-admin-layout title="Edit User">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        @method('PUT')
        @include('admin.users._form')
    </form>
</x-admin-layout>
