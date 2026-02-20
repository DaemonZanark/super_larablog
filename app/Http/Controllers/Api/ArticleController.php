<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    // GET /api/v1/articles
    public function index()
    {
        $articles = Article::with(['user:id,name', 'categories:id,name', 'tags:id,name'])
            ->where('draft', false)
            ->latest()
            ->paginate(request('per_page', 10));

        return response()->json($articles);
    }

    // GET /api/v1/articles/top
    public function top()
    {
        $articles = Article::with(['user:id,name', 'categories:id,name'])
            ->where('draft', false)
            ->orderByDesc('views_count')
            ->limit(request('limit', 5))
            ->get(['id', 'title', 'slug', 'views_count', 'user_id', 'created_at']);

        return response()->json($articles);
    }

    // GET /api/v1/articles/{slug}
    public function show(Article $article)
    {
        if ($article->draft) {
            return response()->json(['message' => 'Article non trouvé.'], 404);
        }

        $article->load([
            'user:id,name,avatar',
            'categories:id,name',
            'tags:id,name',
            'comments' => fn($q) => $q->whereNull('parent_id')->with('user:id,name')->latest(),
        ]);

        return response()->json([
            'id'           => $article->id,
            'title'        => $article->title,
            'slug'         => $article->slug,
            'content'      => strip_tags($article->content),
            'views_count'  => $article->views_count,
            'reading_time' => $article->reading_time,
            'auteur'       => $article->user,
            'categories'   => $article->categories,
            'tags'         => $article->tags,
            'commentaires' => $article->comments,
            'created_at'   => $article->created_at->format('d/m/Y'),
        ]);
    }
}
