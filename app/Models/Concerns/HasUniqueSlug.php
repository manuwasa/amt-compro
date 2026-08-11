<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasUniqueSlug
{
    /**
     * Build a unique slug for this model from the given desired value,
     * appending -2, -3, ... if it collides with another row.
     */
    public static function uniqueSlug(string $desired, ?int $ignoreId = null): string
    {
        $base = Str::slug($desired) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
