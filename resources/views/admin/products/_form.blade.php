@csrf

<div class="mb-6">
    <label for="company_id" class="block text-sm font-medium text-slate-700 mb-1.5">Company</label>
    <select name="company_id" id="company_id" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        <option value="" @selected(old('company_id', $product->company_id) === null)>&mdash; Global (not linked to any company) &mdash;</option>
        @foreach ($companies as $companyOption)
            <option value="{{ $companyOption->id }}" @selected((string) old('company_id', $product->company_id) === (string) $companyOption->id)>{{ $companyOption->name }}</option>
        @endforeach
    </select>
    <p class="text-xs text-slate-400 mt-1">Leave as "Global" for a product available across AMT Group rather than tied to one subsidiary.</p>
    @error('company_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="brand" class="block text-sm font-medium text-slate-700 mb-1.5">Brand</label>
        <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('brand') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category" class="block text-sm font-medium text-slate-700 mb-1.5">Category</label>
        <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('category') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">Slug (optional — derived from name if left blank)</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6">
    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
    <textarea name="description" id="description" rows="4" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('description', $product->description) }}</textarea>
    @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid gap-6 sm:grid-cols-2 mt-6">
    <div>
        <label for="image" class="block text-sm font-medium text-slate-700 mb-1.5">Main Image</label>
        @if ($product->image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="Current image" class="h-16 w-auto mb-2 object-cover rounded-lg border border-slate-200">
        @endif
        <input type="file" name="image" id="image" accept="image/png,image/jpeg,image/webp" class="w-full text-sm">
        @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="gallery" class="block text-sm font-medium text-slate-700 mb-1.5">Gallery (uploading replaces the existing gallery)</label>
        @if (! empty($product->gallery))
            <div class="flex gap-2 mb-2">
                @foreach ($product->gallery as $path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($path) }}" alt="Gallery image" class="h-12 w-12 object-cover rounded-lg border border-slate-200">
                @endforeach
            </div>
        @endif
        <input type="file" name="gallery[]" id="gallery" accept="image/png,image/jpeg,image/webp" multiple class="w-full text-sm">
        @error('gallery.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid gap-6 sm:grid-cols-2 mt-6">
    <div>
        <label for="sort_order" class="block text-sm font-medium text-slate-700 mb-1.5">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
        @error('sort_order') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-2 mt-6">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $product->is_active ?? true)) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
        <label for="is_active" class="text-sm text-slate-700">Visible on the public site</label>
    </div>
</div>

<fieldset class="mt-8 border-t border-slate-100 pt-6">
    <legend class="text-sm font-semibold text-slate-900 mb-4">SEO</legend>

    <div class="grid gap-6 sm:grid-cols-2">
        <div x-data="{ len: {{ strlen((string) old('meta_title', $product->meta_title)) }} }">
            <label for="meta_title" class="block text-sm font-medium text-slate-700 mb-1.5">
                Meta Title <span class="text-slate-400" :class="len > 60 ? 'text-red-500' : ''" x-text="`(${len}/60)`"></span>
            </label>
            <input type="text" name="meta_title" id="meta_title" x-on:input="len = $event.target.value.length" value="{{ old('meta_title', $product->meta_title) }}" placeholder="{{ $product->name ?: 'Falls back to Name' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
            @error('meta_title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ len: {{ strlen((string) old('meta_description', $product->meta_description)) }} }">
            <label for="meta_description" class="block text-sm font-medium text-slate-700 mb-1.5">
                Meta Description <span class="text-slate-400" :class="len > 155 ? 'text-red-500' : ''" x-text="`(${len}/155)`"></span>
            </label>
            <textarea name="meta_description" id="meta_description" x-on:input="len = $event.target.value.length" rows="2" maxlength="500" placeholder="Falls back to Description" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('meta_description', $product->meta_description) }}</textarea>
            @error('meta_description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</fieldset>

<div class="mt-8">
    <x-button variant="primary" type="submit">Save Product</x-button>
</div>
