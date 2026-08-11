<x-admin-layout title="Users">
    <p class="text-sm text-slate-500 mb-4">People with access to this admin panel. Superadmins can also manage Group Settings and other Users.</p>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <x-admin-search placeholder="Search users..." />
        <x-button variant="primary" href="{{ route('admin.users.create') }}">New User</x-button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500 text-xs font-semibold uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-3.5">Name</th>
                    <th class="px-5 py-3.5">Email</th>
                    <th class="px-5 py-3.5">Role</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($users as $user)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $user->email }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium capitalize {{ $user->role === 'superadmin' ? 'bg-brand-50 text-brand-700' : 'bg-slate-100 text-slate-600' }}">{{ $user->role }}</span>
                        </td>
                        <td class="px-5 py-4 text-right space-x-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-slate-500 hover:text-slate-900 hover:underline transition-colors">Edit</a>
                            @if ($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Delete {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 hover:underline transition-colors">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($users->isEmpty())
        <p class="text-slate-500 mt-4">No users found.</p>
    @endif

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-admin-layout>
