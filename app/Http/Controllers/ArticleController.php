<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('articles.index', [
            'articles' => $articles,
        ]);
    }

    public function show(Article $article)
    {
        abort_unless($article->is_published, 404);

        $relatedArticles = Article::query()
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($query, $category) => $query->where('category', $category))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('articles.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
