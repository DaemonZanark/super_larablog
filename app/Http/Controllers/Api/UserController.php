<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/v1/users
    public function index()
    {
        $auteurs = User::withCount([
            'articles as articles_count' => fn($q) => $q->where('draft', false),
            'followers',
        ])
            ->withSum('articles as vues_total', 'views_count')
            ->having('articles_count', '>', 0)
            ->orderByDesc('articles_count')
            ->paginate(request('per_page', 10));

        return response()->json($auteurs);
    }

    // GET /api/v1/users/{user}
    public function show(User $user)
    {
        $user->loadCount([
            'articles as articles_count' => fn($q) => $q->where('draft', false),
            'followers',
            'following',
            'comments',
        ]);

        $articles = $user->articles()
            ->where('draft', false)
            ->orderByDesc('views_count')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'views_count', 'created_at']);

        return response()->json([
            'id'             => $user->id,
            'name'           => $user->name,
            'bio'            => $user->bio,
            'avatar'         => $user->avatar,
            'articles_count' => $user->articles_count,
            'followers'      => $user->followers_count,
            'following'      => $user->following_count,
            'comments_count' => $user->comments_count,
            'top_articles'   => $articles,
        ]);
    }

    public function show_users()
    {
        $user = User::query()->get();
        return response()->json($user);
    }
    public function destroy(User $user)
    {
        $user_admin = auth()->user();

        if (!$user_admin) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if($user_admin->is_admin)
        {
            $user->delete();

            return response()->json(['message' => 'Utilisateurs supprimée.']);
        }
    }
}
