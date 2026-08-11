@props(['name', 'label' => null, 'value' => null, 'minHeight' => 200])

<div>
    @if ($label)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">{{ $label }}</label>
    @endif

    {{-- Left empty on purpose: app.js populates it from the hidden input's value via dangerouslyPasteHTML on load. --}}
    <div data-quill data-quill-target="{{ $name }}-input" class="bg-white" style="min-height: {{ $minHeight }}px"></div>
    <input type="hidden" name="{{ $name }}" id="{{ $name }}-input" value="{{ $value }}">

    @error($name)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
