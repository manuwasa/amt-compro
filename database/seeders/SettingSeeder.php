<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'group_name' => 'AMT Group',
            'group_tagline' => 'Holding company for AMT Group\'s subsidiary businesses.',
            'group_logo' => null,
            'group_favicon' => null,
            'group_bio' => $this->groupBio(),
            'group_portfolio_intro' => 'Companies under the AMT Group umbrella.',
            'group_email' => 'marketing.amtgroup@gmail.com',
            'group_phone' => '085162907801',
            'group_whatsapp_number' => '6285162907801',
            'social_tiktok_url' => 'https://www.tiktok.com/@amtgroup.official',
            'social_instagram_url' => 'https://www.instagram.com/amtgroup.official',
            'meta_description' => 'AMT Group adalah perusahaan induk (holding) yang menaungi unit-unit usaha Agus Susanto, dengan akar bisnis di distribusi ban truck dan layanan vulkanisir ban.',
            'meta_keywords' => 'AMT Group, PT Susanto Group, holding company, CV AMT Jaya Ban, ban truck, vulkanisir ban',
            'mail_mailer' => null,
            'mail_host' => null,
            'mail_port' => null,
            'mail_username' => null,
            'mail_password' => null,
            'mail_encryption' => null,
            'mail_from_address' => null,
            'mail_from_name' => null,
        ];

        foreach ($defaults as $key => $value) {
            Setting::set($key, $value);
        }
    }

    /**
     * Short holding-level biography rendered in the homepage "About Us" section.
     * Each subsidiary's own full profile lives on its Our Services page instead.
     */
    private function groupBio(): string
    {
        return <<<'HTML'
            <p>AMT Group adalah perusahaan induk (holding) yang menaungi dan mengembangkan unit-unit usaha yang dibangun oleh Agus Susanto, dengan akar bisnis di bidang otomotif - distribusi ban truck dan layanan vulkanisir ban.</p>

            <p>Secara legalitas, AMT Group dijalankan melalui PT Susanto Group yang didirikan pada tahun 2025 sebagai perusahaan holding. Pembentukan holding ini menjadi langkah penataan usaha agar setiap unit bisnis dapat tumbuh dengan tata kelola, standar operasional, dan strategi pengembangan yang terarah.</p>

            <p>Melalui unit-unit usahanya, AMT Group melayani pelanggan di berbagai wilayah Indonesia, mulai dari armada pertambangan dan perusahaan pengguna truck hingga pelanggan ritel. Profil lengkap setiap unit usaha dapat dilihat pada halaman Our Services.</p>
            HTML;
    }
}
