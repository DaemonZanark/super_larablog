<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->get();
        return response()->json($categories);
    }

    public function destroy(Category $category)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if($user->is_admin)
        {
            $category->articles()->detach();
            $category->delete();

            return response()->json(['message' => 'Catégorie supprimée.']);
        }
    }
}
