<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Placeholder published articles so /articles isn't empty at demo time.
     * user_id is left null: no admin user exists yet at seed time (created
     * afterwards via `php artisan admin:create`).
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Mengenal Standar SNI pada Ban Kendaraan',
                'excerpt' => 'Apa itu standar SNI untuk ban, dan mengapa hal ini penting bagi keselamatan berkendara di Indonesia.',
                'content' => '<p>Standar Nasional Indonesia (SNI) untuk ban memastikan setiap ban yang beredar telah melalui pengujian keamanan dan kualitas. Bagi distributor seperti PT ABC Jaya Sejahtera, memastikan seluruh produk memenuhi standar ini adalah komitmen utama.</p><p>Konsumen disarankan untuk selalu memeriksa label SNI sebelum membeli ban baru, guna memastikan produk yang digunakan aman dan sesuai regulasi.</p>',
                'category' => 'Tips',
                'tags' => 'sni, ban, keselamatan',
            ],
            [
                'title' => 'Tips Merawat Ban Agar Lebih Awet',
                'excerpt' => 'Beberapa langkah sederhana untuk memperpanjang usia pakai ban kendaraan Anda.',
                'content' => '<p>Merawat ban dengan baik tidak hanya memperpanjang usia pakainya, tetapi juga meningkatkan keselamatan berkendara. Berikut beberapa tips dasar:</p><ul><li>Periksa tekanan angin secara rutin.</li><li>Lakukan rotasi ban setiap 10.000 km.</li><li>Perhatikan keseimbangan (balancing) dan spooring kendaraan.</li></ul>',
                'category' => 'Tips',
                'tags' => 'perawatan, ban, kendaraan',
            ],
            [
                'title' => 'AMT Group Perluas Jaringan Distribusi ke Kalimantan dan Sulawesi',
                'excerpt' => 'Ekspansi jaringan distribusi menjadi bagian dari komitmen AMT Group melayani lebih banyak wilayah di Indonesia.',
                'content' => '<p>Sejak 2023, PT ABC Jaya Sejahtera, salah satu anak perusahaan AMT Group, telah memperluas jaringan distribusinya ke wilayah Kalimantan dan Sulawesi. Langkah ini merupakan bagian dari strategi jangka panjang untuk menghadirkan produk ban original dan berstandar SNI ke lebih banyak pelanggan di seluruh Indonesia.</p>',
                'category' => 'Company News',
                'tags' => 'amt group, ekspansi, distribusi',
            ],
        ];

        foreach ($articles as $index => $article) {
            Article::create([
                ...$article,
                'slug' => Article::uniqueSlug($article['title']),
                'featured_image_alt' => $article['title'],
                'is_published' => true,
                'published_at' => now()->subDays((count($articles) - $index) * 3),
            ]);
        }
    }
}
