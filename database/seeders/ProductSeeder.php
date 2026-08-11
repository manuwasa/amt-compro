<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Befriend models are migrated from the old abcjayasejahtera.com site.
     * Deolus is mentioned in PT ABC Jaya Sejahtera's bio as a distributed brand,
     * but the old site published no specific Deolus models, so none are seeded
     * here — the client should supply real Deolus catalog data before launch.
     */
    public function run(): void
    {
        $company = Company::where('slug', 'pt-abc-jaya-sejahtera')->first();

        if (! $company) {
            return;
        }

        $befriendModels = ['BF918', 'BF902', 'BF903', 'BF303', 'BF802', 'BF801'];

        foreach ($befriendModels as $index => $model) {
            Product::create([
                'company_id' => $company->id,
                'brand' => 'Befriend',
                'name' => $model,
                'slug' => Product::uniqueSlug($model),
                'description' => "Befriend {$model} — original, SNI-standard tire distributed by PT ABC Jaya Sejahtera.",
                'category' => 'Tire',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
