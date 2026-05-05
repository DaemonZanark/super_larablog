<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    //
    public function index()
    {
        $tag = Tag::with('articles')->get();
        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if($user->is_admin)
        {
            $tag->articles()->detach();
            $tag->delete();

            return response()->json(['message' => 'Tags supprimée.']);
        }
    }
}
