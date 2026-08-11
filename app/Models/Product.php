<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasUniqueSlug;

    protected $fillable = [
        'company_id',
        'brand',
        'name',
        'slug',
        'description',
        'image',
        'gallery',
        'category',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function metaTitle(): string
    {
        return $this->meta_title ?: $this->name;
    }

    public function metaDescription(): ?string
    {
        return $this->meta_description ?: str($this->description)->limit(160)->value();
    }
}
