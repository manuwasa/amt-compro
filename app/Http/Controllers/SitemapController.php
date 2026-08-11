<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $staticPages = [
            ['url' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['url' => route('companies.index'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['url' => route('products.index'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => route('articles.index'), 'changefreq' => 'daily', 'priority' => '0.7'],
            ['url' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        $companies = Company::query()->where('is_active', true)->get()->map(fn (Company $company) => [
            'url' => route('companies.show', $company),
            'lastmod' => $company->updated_at,
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ]);

        $products = Product::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('company_id')->orWhereHas('company', fn ($q) => $q->where('is_active', true));
            })
            ->get()
            ->map(fn (Product $product) => [
            'url' => route('products.show', $product),
            'lastmod' => $product->updated_at,
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ]);

        $articles = Article::query()->where('is_published', true)->get()->map(fn (Article $article) => [
            'url' => route('articles.show', $article),
            'lastmod' => $article->updated_at,
            'changefreq' => 'monthly',
            'priority' => '0.6',
        ]);

        $urls = collect($staticPages)->concat($companies)->concat($products)->concat($articles);

        return Response::view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'text/xml');
    }
}
