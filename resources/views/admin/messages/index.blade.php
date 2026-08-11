<x-admin-layout title="Messages">
    <p class="text-sm text-slate-500 mb-4">Submissions from the public Contact Us form.</p>

    <div class="mb-6">
        <x-admin-search placeholder="Search messages..." />
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500 text-xs font-semibold uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-3.5">From</th>
                    <th class="px-5 py-3.5">Subject</th>
                    <th class="px-5 py-3.5">Received</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($messages as $message)
                    <tr class="hover:bg-slate-50/60 transition-colors {{ $message->is_read ? '' : 'bg-brand-50/40' }}">
                        <td class="px-5 py-4">
                            <div class="font-medium text-slate-900">{{ $message->name }}</div>
                            <div class="text-slate-500">{{ $message->email }}</div>
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ $message->subject ?: '—' }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $message->created_at->format('d M Y H:i') }}</td>
                        <td class="px-5 py-4">
                            @if ($message->is_read)
                                <span class="inline-flex rounded-full bg-slate-100 text-slate-500 px-2.5 py-1 text-xs font-medium">Read</span>
                            @else
                                <span class="inline-flex rounded-full bg-brand-50 text-brand-700 px-2.5 py-1 text-xs font-medium">Unread</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right space-x-4">
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-slate-500 hover:text-slate-900 hover:underline transition-colors">View</a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Delete this message?');">
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

    @if ($messages->isEmpty())
        <p class="text-slate-500 mt-4">No messages yet.</p>
    @endif

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</x-admin-layout>
