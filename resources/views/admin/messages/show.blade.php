<x-admin-layout title="Message Detail">
    <a href="{{ route('admin.messages.index') }}" class="text-sm text-slate-500 hover:text-slate-900 transition-colors">&larr; Back to Messages</a>

    <div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 p-6 mt-4 space-y-4 text-sm">
        <div>
            <div class="text-slate-500">From</div>
            <div class="font-medium text-slate-900">{{ $message->name }} &lt;{{ $message->email }}&gt;</div>
        </div>

        @if ($message->phone)
            <div>
                <div class="text-slate-500">Phone</div>
                <div class="font-medium text-slate-900">{{ $message->phone }}</div>
            </div>
        @endif

        @if ($message->subject)
            <div>
                <div class="text-slate-500">Subject</div>
                <div class="font-medium text-slate-900">{{ $message->subject }}</div>
            </div>
        @endif

        <div>
            <div class="text-slate-500">Message</div>
            <p class="whitespace-pre-line text-slate-700">{{ $message->message }}</p>
        </div>

        <div class="text-slate-400 text-xs">Received {{ $message->created_at->format('d M Y H:i') }}</div>

        <div class="pt-4 border-t border-slate-100">
            <x-button variant="primary" href="mailto:{{ $message->email }}?subject={{ urlencode('Re: '.$message->subject) }}">
                Reply by Email
            </x-button>
        </div>
    </div>
</x-admin-layout>
