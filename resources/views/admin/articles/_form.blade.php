@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
    <div class="lg:col-span-2 space-y-6">
        <div>
            <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors text-lg">
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-quill-editor name="content" label="Content" :value="old('content', $article->content)" :min-height="480" />
        </div>

        <div>
            <label for="excerpt" class="block text-sm font-medium text-slate-700 mb-1.5">Excerpt</label>
            <textarea name="excerpt" id="excerpt" rows="3" maxlength="1000" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('excerpt', $article->excerpt) }}</textarea>
            @error('excerpt') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <fieldset class="border-t border-slate-100 pt-6">
            <legend class="text-sm font-semibold text-slate-900 mb-4">SEO</legend>

            <div class="grid gap-6 sm:grid-cols-2">
                <div x-data="{ len: {{ strlen((string) old('meta_title', $article->meta_title)) }} }">
                    <label for="meta_title" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Meta Title <span class="text-slate-400" :class="len > 60 ? 'text-red-500' : ''" x-text="`(${len}/60)`"></span>
                    </label>
                    <input type="text" name="meta_title" id="meta_title" x-on:input="len = $event.target.value.length" value="{{ old('meta_title', $article->meta_title) }}" placeholder="{{ $article->title ?: 'Falls back to Title' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                    @error('meta_title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-data="{ len: {{ strlen((string) old('meta_description', $article->meta_description)) }} }">
                    <label for="meta_description" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Meta Description <span class="text-slate-400" :class="len > 155 ? 'text-red-500' : ''" x-text="`(${len}/155)`"></span>
                    </label>
                    <textarea name="meta_description" id="meta_description" x-on:input="len = $event.target.value.length" rows="2" maxlength="500" placeholder="Falls back to Excerpt" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">{{ old('meta_description', $article->meta_description) }}</textarea>
                    @error('meta_description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>
    </div>

    <div class="space-y-6 lg:sticky lg:top-6">
        <div class="rounded-xl border border-slate-200 p-4 space-y-4">
            <h3 class="text-sm font-semibold text-slate-900">Publish</h3>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" id="is_published" value="1" @checked(old('is_published', $article->is_published ?? false)) class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                <label for="is_published" class="text-sm text-slate-700">Published</label>
            </div>

            <div>
                <label for="published_at" class="block text-sm font-medium text-slate-700 mb-1.5">Published At</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                <p class="text-xs text-slate-400 mt-1">Defaults to now if left blank and Published is checked.</p>
                @error('published_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <x-button variant="primary" type="submit" class="w-full justify-center">Save Article</x-button>
        </div>

        <div class="rounded-xl border border-slate-200 p-4 space-y-4">
            <h3 class="text-sm font-semibold text-slate-900">Slug</h3>
            <div>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $article->slug) }}" placeholder="Derived from title if left blank" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 p-4 space-y-4">
            <h3 class="text-sm font-semibold text-slate-900">Category &amp; Tags</h3>

            <div>
                <label for="category" class="block text-sm font-medium text-slate-700 mb-1.5">Category</label>
                <input type="text" name="category" id="category" value="{{ old('category', $article->category) }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                @error('category') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-slate-700 mb-1.5">Tags (comma-separated)</label>
                <input type="text" name="tags" id="tags" value="{{ old('tags', $article->tags) }}" placeholder="tire, sni, distribution" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                @error('tags') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 p-4 space-y-4">
            <h3 class="text-sm font-semibold text-slate-900">Featured Image</h3>

            <div>
                @if ($article->featured_image)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($article->featured_image) }}" alt="Current featured image" class="h-24 w-full object-cover rounded-lg border border-slate-200 mb-2">
                @endif
                <input type="file" name="featured_image" id="featured_image" accept="image/png,image/jpeg,image/webp" class="w-full text-sm">
                @error('featured_image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="featured_image_alt" class="block text-sm font-medium text-slate-700 mb-1.5">Alt Text</label>
                <input type="text" name="featured_image_alt" id="featured_image_alt" value="{{ old('featured_image_alt', $article->featured_image_alt) }}" placeholder="{{ $article->title ?: 'Falls back to Title' }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors">
                <p class="text-xs text-slate-400 mt-1">Required for accessibility and image SEO.</p>
                @error('featured_image_alt') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>
