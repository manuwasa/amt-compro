<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mews\Purifier\Facades\Purifier;

class Article extends Model
{
    use HasUniqueSlug;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'tags',
        'category',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function setContentAttribute(?string $value): void
    {
        $this->attributes['content'] = $value ? Purifier::clean($value) : $value;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tagList(): array
    {
        return $this->tags
            ? array_filter(array_map('trim', explode(',', $this->tags)))
            : [];
    }

    public function metaTitle(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function metaDescription(): ?string
    {
        return $this->meta_description ?: ($this->excerpt ?: str($this->content)->stripTags()->limit(160)->value());
    }
}
