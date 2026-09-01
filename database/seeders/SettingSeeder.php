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
            'group_bio' => '<p>AMT Group is a holding company overseeing a portfolio of subsidiary businesses, including PT ABC Jaya Sejahtera.</p>',
            'group_portfolio_intro' => 'Companies under the AMT Group umbrella.',
            'group_email' => 'marketing.amtgroup@gmail.com',
            'group_phone' => '085162907801',
            'group_whatsapp_number' => '6285162907801',
            'social_tiktok_url' => '',
            'social_instagram_url' => '',
            'meta_description' => 'AMT Group is a holding company overseeing a portfolio of subsidiary businesses across Indonesia.',
            'meta_keywords' => 'AMT Group, holding company, PT ABC Jaya Sejahtera',
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
}
