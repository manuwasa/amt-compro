<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * CV AMT Jaya Ban and PT ABC Jaya Sejahtera are seeded with real content —
     * the former holds the profile that used to sit on the group homepage before
     * the homepage became AMT Group's own (holding) biography. CV B/C are
     * placeholders the client fills in later via the admin panel — kept active so
     * the public "Our Services" directory and the admin CRUD are demonstrably
     * functional before launch.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'CV AMT Jaya Ban',
            'slug' => 'cv-amt-jaya-ban',
            'bio' => $this->amtJayaBanBio(),
            'address' => 'Cibitung, Kabupaten Bekasi',
            'phone' => '085162907801',
            'whatsapp_number' => '6285162907801',
            'email' => 'marketing.amtgroup@gmail.com',
            'is_active' => true,
            'sort_order' => 1,
            'meta_title' => 'CV AMT Jaya Ban — Distributor Ban Truck & Vulkanisir Ban',
            'meta_description' => 'CV AMT Jaya Ban berdiri sejak 2007 sebagai distributor ban truck dan penyedia layanan vulkanisir ban metode dingin (cold retread) untuk armada pertambangan dan pengguna truck di seluruh Indonesia.',
        ]);

        Company::create([
            'name' => 'PT ABC Jaya Sejahtera',
            'slug' => 'pt-abc-jaya-sejahtera',
            'bio' => $this->abcJayaBio(),
            'address' => 'Jl. Teuku Umar, Gg. Kantor Pos RT.004 RW.005 DS. Telaga Asih, Kec. Cikarang, Kab. Bekasi',
            'phone' => '021 221 627 22',
            'whatsapp_number' => null,
            'email' => 'abc.official@sabcjaya.co.id',
            'is_active' => true,
            'sort_order' => 2,
            'meta_title' => 'PT ABC Jaya Sejahtera — Original Tire Distributor',
            'meta_description' => 'PT ABC Jaya Sejahtera distributes new, original, SNI-standard tires including the Befriend and Deolus brands, serving Bekasi and beyond since 2021.',
        ]);

        foreach (['CV B', 'CV C'] as $index => $name) {
            Company::create([
                'name' => $name,
                'slug' => Company::uniqueSlug($name),
                'bio' => '<p>Profil perusahaan akan segera diperbarui.</p>',
                'is_active' => true,
                'sort_order' => $index + 3,
            ]);
        }
    }

    /**
     * The CV AMT Jaya Ban profile — the narrative plus the identity table and
     * commitment statement that were previously hard-coded on the group homepage.
     */
    private function amtJayaBanBio(): string
    {
        return <<<'HTML'
            <p>CV AMT Jaya Ban merupakan perusahaan yang bergerak di bidang otomotif, khususnya distribusi dan pengolahan ban untuk kendaraan niaga, dengan fokus utama pada ban truck dan layanan vulkanisir ban. Perusahaan didirikan pada tahun 2007 oleh Agus Susanto dengan melihat besarnya potensi dan kebutuhan pasar terhadap ban vulkanisir, terutama untuk mendukung operasional kendaraan niaga yang membutuhkan efisiensi biaya dan kualitas produk yang andal.</p>

            <p>Perjalanan CV AMT Jaya Ban berawal dari sebuah toko kecil. Seiring dengan meningkatnya kepercayaan pelanggan dan kebutuhan pasar, perusahaan mengembangkan kemampuan produksinya hingga mampu memproduksi ban vulkanisir secara mandiri. Perkembangan tersebut menjadi bagian penting dalam membangun kapasitas usaha serta memperkuat posisi perusahaan dalam industri ban truck.</p>

            <p>Dalam perkembangannya, CV AMT Jaya Ban terus memperluas jaringan dan kapasitas usaha. Perusahaan kini memiliki gudang sendiri di Cibitung serta jaringan cabang di Rembang, Kalimantan, dan Sulawesi. Selain menjalankan distribusi ban truck, perusahaan juga mengembangkan kegiatan impor ban dari China untuk memenuhi kebutuhan pasar dan memperluas pilihan produk bagi pelanggan.</p>

            <p>Sebagai distributor ban truck, CV AMT Jaya Ban melayani kebutuhan pelanggan di berbagai wilayah Indonesia, dengan target utama armada pertambangan dan perusahaan pengguna truck. Salah satu layanan unggulan perusahaan adalah vulkanisir ban dengan metode dingin (cold retread), yang ditujukan untuk menghasilkan produk vulkanisir berkualitas premium dengan mempertimbangkan aspek efisiensi dan keandalan penggunaan.</p>

            <p>Komitmen terhadap kualitas juga diwujudkan melalui layanan garansi dan after-sales service. Dalam kondisi tertentu, termasuk apabila terjadi ngelotok pada ban saat digunakan sesuai ketentuan garansi, perusahaan menyediakan layanan penanganan sebagai bentuk tanggung jawab terhadap produk dan kepuasan pelanggan.</p>

            <p><strong>Identitas Perusahaan</strong></p>
            <ul>
                <li><strong>Nama Perusahaan</strong> &mdash; CV AMT Jaya Ban</li>
                <li><strong>Tahun Berdiri</strong> &mdash; 2007</li>
                <li><strong>Pendiri</strong> &mdash; Agus Susanto</li>
                <li><strong>Bentuk Usaha</strong> &mdash; Commanditaire Vennootschap (CV)</li>
                <li><strong>Lokasi Kantor</strong> &mdash; Cibitung</li>
                <li><strong>Bidang Usaha</strong> &mdash; Otomotif, distribusi ban truck dan vulkanisir ban</li>
                <li><strong>Produk Utama</strong> &mdash; Distributor ban truck</li>
                <li><strong>Layanan Unggulan</strong> &mdash; Vulkanisir ban dengan metode dingin</li>
                <li><strong>Target Pelanggan</strong> &mdash; Armada pertambangan dan pengguna truck</li>
                <li><strong>Wilayah Distribusi</strong> &mdash; Seluruh Indonesia</li>
                <li><strong>Jaringan Operasional</strong> &mdash; Cibitung, Rembang, Kalimantan, dan Sulawesi</li>
                <li><strong>Kegiatan Perdagangan</strong> &mdash; Distribusi dan impor ban dari China</li>
            </ul>

            <p><strong>Komitmen Perusahaan</strong></p>
            <p>CV AMT Jaya Ban berkomitmen untuk terus mengembangkan kualitas produk, kapasitas produksi, jaringan distribusi, serta pelayanan purna jual. Dengan pengalaman sejak 2007 dan jaringan yang terus berkembang, perusahaan berupaya menjadi mitra yang dapat diandalkan bagi pelanggan dalam memenuhi kebutuhan ban truck dan solusi vulkanisir di Indonesia.</p>
            HTML;
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
