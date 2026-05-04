<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;

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


    public function authors()
    {
        $authors = User::query()
            ->whereHas('articles', function ($q) {
                $q->where('draft', false);
            })
            ->withCount([
                'articles as articles_count' => function ($q) {
                    $q->where('draft', false);
                }
            ])
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($authors);
    }

    public function authors_articles(User $user)
    {
        $articles = $user->articles()
            ->where('draft', false)
            ->latest()
            ->get([
                'id',
                'title',
                'slug',
                'created_at',
                'views_count',
                'image'
            ]);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'articles_count' => $articles->count(),
            'articles' => $articles
        ]);
    }

    public function destroy(Article $article)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (
            $user->is_admin ||
            $article->user_id === $user->id
        ) {
            $article->delete();

            return response()->json(['message' => 'Article supprimé avec succès.']);
        }
        return response()->json(['message' => 'Action non autorisée.'], 403);
    }
}
