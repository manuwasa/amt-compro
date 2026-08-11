<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * PT ABC Jaya Sejahtera is seeded with real content migrated from the old
     * abcjayasejahtera.com site. CV A/B/C are placeholders the client fills in
     * later via the admin panel — kept active so the public "Our Services"
     * directory and the admin CRUD are demonstrably functional before launch.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'PT ABC Jaya Sejahtera',
            'slug' => 'pt-abc-jaya-sejahtera',
            'bio' => $this->abcJayaBio(),
            'address' => 'Jl. Teuku Umar, Gg. Kantor Pos RT.004 RW.005 DS. Telaga Asih, Kec. Cikarang, Kab. Bekasi',
            'phone' => '021 221 627 22',
            'whatsapp_number' => null,
            'email' => 'abc.official@sabcjaya.co.id',
            'is_active' => true,
            'sort_order' => 1,
            'meta_title' => 'PT ABC Jaya Sejahtera — Original Tire Distributor',
            'meta_description' => 'PT ABC Jaya Sejahtera distributes new, original, SNI-standard tires including the Befriend and Deolus brands, serving Bekasi and beyond since 2021.',
        ]);

        foreach (['CV A', 'CV B', 'CV C'] as $index => $name) {
            Company::create([
                'name' => $name,
                'slug' => Company::uniqueSlug($name),
                'bio' => '<p>Profil perusahaan akan segera diperbarui.</p>',
                'is_active' => true,
                'sort_order' => $index + 2,
            ]);
        }
    }

    private function abcJayaBio(): string
    {
        return <<<'HTML'
            <p>PT ABC Jaya Sejahtera was established on 14 October 2021 at Jl Arteri Toll Cibitung, West Cikarang, Bekasi, as a distributor of new, original, SNI-standard tires.</p>

            <h3>Vision</h3>
            <p>Becoming a company that provides new (original) tires with SNI standards, high quality, superior, reliable, and popular with customers.</p>

            <h3>Mission</h3>
            <p>We emphasize product and service quality, actively listening to internal and external feedback while implementing continuous improvement across our distribution network.</p>

            <h3>Company Timeline</h3>
            <ul>
                <li><strong>2021</strong> — Company establishment at Jl Arteri Toll Cibitung, West Cikarang, Bekasi.</li>
                <li><strong>2022</strong> — Construction of our primary distribution warehouse in Bekasi.</li>
                <li><strong>2022–2023</strong> — Partnerships established with multiple tire brand importers, including Befriend and Deolus.</li>
                <li><strong>2023–Present</strong> — Expansion of our distribution network into Kalimantan and Sulawesi.</li>
            </ul>

            <h3>Leadership</h3>
            <p>Our organization is led by Owner Agus Susanto, supported by a General Affairs Director, a Finance Director with a supporting manager, and a Sales Director overseeing regional operations.</p>
            HTML;
    }
}
