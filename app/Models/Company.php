<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mews\Purifier\Facades\Purifier;

class Company extends Model
{
    use HasUniqueSlug;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'cover_image',
        'bio',
        'address',
        'phone',
        'whatsapp_number',
        'email',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function setBioAttribute(?string $value): void
    {
        $this->attributes['bio'] = $value ? Purifier::clean($value) : $value;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function whatsappUrl(): ?string
    {
        if (! $this->whatsapp_number) {
            return null;
        }

        return 'https://wa.me/'.preg_replace('/\D/', '', $this->whatsapp_number);
    }

    public function metaTitle(): string
    {
        return $this->meta_title ?: $this->name;
    }

    public function metaDescription(): ?string
    {
        return $this->meta_description ?: str($this->bio)->stripTags()->limit(160)->value();
    }
}
