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
}
