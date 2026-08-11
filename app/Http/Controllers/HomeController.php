<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticles = Article::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('home', [
            'latestArticles' => $latestArticles,
        ]);
    }
}
