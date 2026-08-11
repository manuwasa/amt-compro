<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $articles = Article::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.articles.index', ['articles' => $articles]);
    }

    public function create(): View
    {
        return view('admin.articles.create', ['article' => new Article()]);
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Article::uniqueSlug(($data['slug'] ?? null) ?: $data['title']);
        $data['user_id'] = $request->user()->id;
        $data['is_published'] = $request->boolean('is_published');
        $data['featured_image_alt'] = ($data['featured_image_alt'] ?? null) ?: $data['title'];

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'Article created.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', ['article' => $article]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Article::uniqueSlug(($data['slug'] ?? null) ?: $data['title'], $article->id);
        $data['is_published'] = $request->boolean('is_published');
        $data['featured_image_alt'] = ($data['featured_image_alt'] ?? null) ?: $data['title'];

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = $article->published_at ?: now();
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', 'Article updated.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('status', 'Article deleted.');
    }
}
