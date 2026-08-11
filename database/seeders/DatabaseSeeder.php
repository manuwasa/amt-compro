<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * No demo user is seeded here: admin accounts are created interactively
     * via `php artisan admin:create` so no plaintext password ever lands in
     * version control or a seeder.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            CompanySeeder::class,
            ProductSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
