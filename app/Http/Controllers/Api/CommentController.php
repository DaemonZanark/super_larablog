<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    // GET /api/v1/comments/latest
    public function latest()
    {
        $commentaires = Comment::with([
            'user:id,name,avatar',
            'article:id,title,slug',
        ])
            ->whereNull('parent_id')
            ->latest()
            ->limit(request('limit', 10))
            ->get(['id', 'user_id', 'article_id', 'content', 'created_at']);

        return response()->json($commentaires);
    }

    public function destroy(Comment $comment)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (
            $user->is_admin ||
            $comment->user_id === $user->id ||
            $comment->article?->user_id === $user->id
        ) {
            $comment->replies()->delete();
            $comment->delete();

            return response()->json(['message' => 'Commentaire supprimé.']);
        }
        return response()->json(['message' => 'Action non autorisée.'], 403);
    }
}
