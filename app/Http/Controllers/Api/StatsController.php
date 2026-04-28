<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    // GET /api/v1/stats → tout en un seul appel pour Unity
    public function index()
    {
        return response()->json([
            'global'     => $this->getGlobal(),
            'engagement' => $this->getEngagement(),
            'recent'     => $this->getRecent(),
            'community'  => $this->getCommunity(),
        ]);
    }

    // GET /api/v1/stats/articles
    public function articles()
    {
        return response()->json($this->getGlobal());
    }

    // GET /api/v1/stats/comments
    public function comments()
    {
        return response()->json([
            'comments_total'           => Comment::count(),
            'comments_last_7d'         => Comment::where('created_at', '>=', now()->subDays(7))->count(),
            'comments_last_30d'        => Comment::where('created_at', '>=', now()->subDays(30))->count(),
            'avg_comments_per_article' => round(Comment::count() / max(Article::where('draft', false)->count(), 1), 1),
        ]);
    }

    public function users()
    {
        return response()->json($this->getCommunity());
    }

    // GET /api/v1/stats/activity → graphiques barres Unity sur 7 jours
    public function activity()
    {
        $dates = $donneesArticles = $donneesCommentaires = $donneesLikes = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates->push(now()->subDays($i)->format('d/m'));
            $donneesArticles->push(Article::where('draft', false)->whereDate('created_at', $date)->count());
            $donneesCommentaires->push(Comment::whereDate('created_at', $date)->count());
            $donneesLikes->push(DB::table('article_user')->whereDate('created_at', $date)->count());
        }

        return response()->json([
            'labels'       => $dates,
            'articles'     => $donneesArticles,
            'commentaires' => $donneesCommentaires,
            'likes'        => $donneesLikes,
        ]);
    }

    private function getGlobal(): array
    {
        return [
            'articles_total' => Article::where('draft', false)->count(),
            'articles_draft' => Article::where('draft', true)->count(),
            'views_total'    => Article::sum('views_count'),
            'views_moyenne'  => round(Article::where('draft', false)->avg('views_count'), 1),
        ];
    }

    private function getEngagement(): array
    {
        $totalArticles = max(Article::where('draft', false)->count(), 1);
        $totalLikes    = DB::table('article_user')->count();
        return [
            'likes_total'              => $totalLikes,
            'avg_likes_per_article'    => round($totalLikes / $totalArticles, 1),
            'comments_total'           => Comment::count(),
            'avg_comments_per_article' => round(Comment::count() / $totalArticles, 1),
        ];
    }

    private function getRecent(): array
    {
        return [
            'articles_last_7d'  => Article::where('draft', false)->where('created_at', '>=', now()->subDays(7))->count(),
            'articles_last_30d' => Article::where('draft', false)->where('created_at', '>=', now()->subDays(30))->count(),
            'comments_last_7d'  => Comment::where('created_at', '>=', now()->subDays(7))->count(),
            'comments_last_30d' => Comment::where('created_at', '>=', now()->subDays(30))->count(),
        ];
    }

    private function getCommunity(): array
    {
        return [
            'users_total'           => User::count(),
            'auteurs_actifs'        => User::whereHas('articles', fn($q) => $q->where('draft', false))->count(),
            'subscriptions_total'   => Subscription::count(),
            'subscriptions_last_7d' => Subscription::recent()->count(),
            'top_auteurs'           => Subscription::topAuthors(5)->with('author:id,name')->get()
                ->map(fn($s) => ['auteur' => $s->author->name ?? 'Inconnu', 'followers' => $s->followers_count]),
        ];
    }
}
