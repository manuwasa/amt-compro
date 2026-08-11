@csrf

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">Slug (optional — derived from name if left blank)</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $company->slug) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid gap-6 sm:grid-cols-2 mt-6">
    <div>
        <label for="logo" class="block text-sm font-medium text-slate-700 mb-1.5">Logo</label>
        @if ($company->logo)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($company->logo) }}" alt="Current logo" class="h-12 w-auto mb-2 object-contain">
        @endif
        <input type="file" name="logo" id="logo" accept="image/png,image/jpeg,image/webp" class="w-full text-sm">
        @error('logo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="cover_image" class="block text-sm font-medium text-slate-700 mb-1.5">Cover Image</label>
        @if ($company->cover_image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($company->cover_image) }}" alt="Current cover" class="h-12 w-auto mb-2 object-contain">
        @endif
        <input type="file" name="cover_image" id="cover_image" accept="image/png,image/jpeg,image/webp" class="w-full text-sm">
        @error('cover_image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6">
    <x-quill-editor name="bio" label="Biography" :value="old('bio', $company->bio)" />
</div>

<div class="grid gap-6 sm:grid-cols-2 mt-6">
    <div class="sm:col-span-2">
        <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
        <textarea name="address" id="address" rows="2" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('address', $company->address) }}</textarea>
        @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $company->phone) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="whatsapp_number" class="block text-sm font-medium text-slate-700 mb-1.5">WhatsApp Number</label>
        <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $company->whatsapp_number) }}" placeholder="62812xxxxxxx" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('whatsapp_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $company->email) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium text-slate-700 mb-1.5">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $company->sort_order ?? 0) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('sort_order') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex items-center gap-2">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $company->is_active ?? true)) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
    <label for="is_active" class="text-sm text-slate-700">Visible on the public site</label>
</div>

<fieldset class="mt-8 border-t border-slate-100 pt-6">
    <legend class="text-sm font-semibold text-slate-900 mb-4">SEO</legend>

    <div class="grid gap-6 sm:grid-cols-2">
        <div x-data="{ len: {{ strlen((string) old('meta_title', $company->meta_title)) }} }">
            <label for="meta_title" class="block text-sm font-medium text-slate-700 mb-1.5">
                Meta Title <span class="text-slate-400" :class="len > 60 ? 'text-red-500' : ''" x-text="`(${len}/60)`"></span>
            </label>
            <input type="text" name="meta_title" id="meta_title" x-on:input="len = $event.target.value.length" value="{{ old('meta_title', $company->meta_title) }}" placeholder="{{ $company->name ?: 'Falls back to Name' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
            @error('meta_title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ len: {{ strlen((string) old('meta_description', $company->meta_description)) }} }">
            <label for="meta_description" class="block text-sm font-medium text-slate-700 mb-1.5">
                Meta Description <span class="text-slate-400" :class="len > 155 ? 'text-red-500' : ''" x-text="`(${len}/155)`"></span>
            </label>
            <textarea name="meta_description" id="meta_description" x-on:input="len = $event.target.value.length" rows="2" maxlength="500" placeholder="Falls back to Biography" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('meta_description', $company->meta_description) }}</textarea>
            @error('meta_description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</fieldset>

<div class="mt-8">
    <x-button variant="primary" type="submit">Save Company</x-button>
</div>
