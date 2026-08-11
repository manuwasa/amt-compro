<x-mail::message>
# New Contact Message

**From:** {{ $contactMessage->name }} ({{ $contactMessage->email }})

@if ($contactMessage->phone)
**Phone:** {{ $contactMessage->phone }}
@endif

@if ($contactMessage->subject)
**Subject:** {{ $contactMessage->subject }}
@endif

{{ $contactMessage->message }}

<x-mail::button :url="route('admin.messages.show', $contactMessage)">
View in Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
