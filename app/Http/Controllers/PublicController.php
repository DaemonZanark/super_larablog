<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{

    public function home(Request $request)
    {
        $requete = Article::with(['user', 'categories'])
            ->where('draft', 0);

        if ($request->filled('category')) {
            $requete->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $articles = $requete->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('welcome', compact('articles', 'categories'));
    }

    public function index(User $user, Request $request)
    {
        $recherche = Article::with(['categories', 'tags'])
            ->where('user_id', $user->id)
            ->where('draft', 0);

        if ($request->filled('search')) {
            $motCle = $request->search;
            $recherche->where(function($q) use ($motCle) {
                $q->where('title', 'like', "%{$motCle}%")
                  ->orWhere('content', 'like', "%{$motCle}%");
            });
        }

        if ($request->filled('category')) {
            $recherche->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        if ($request->filled('tag')) {
            $recherche->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        $articles = $recherche->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $tags = Tag::all();

        return view('public.index', compact('articles', 'user', 'categories', 'tags'));
    }

    public function show(User $user, Article $article)
    {
        $article->load([
            'categories',
            'tags',
            'comments' => function($q) {
                $q->whereNull('parent_id')->with(['user', 'replies.user'])->latest();
            },
            'user',
            'likes'
        ]);

        if($article->draft)
        {
            abort(404);
        }

        $article->increment('views_count');

        return view('public.show',['article'=>$article,'user'=>$user]);

    }

    public function listeAuteurs()
    {
        $lesAuteurs = User::withCount(['articles' => function($q) {
            $q->where('draft', false);
        }])
        ->having('articles_count', '>', 0)
        ->paginate(12);

        return view('public.authors', ['authors' => $lesAuteurs]);
    }

    public function profilAuteur(User $user)
    {
        $user->loadCount(['articles' => function($q) {
            $q->where('draft', false);
        }, 'followers']);

        $lesArticles = $user->articles()
            ->where('draft', false)
            ->latest()
            ->paginate(6);

        return view('public.author_profile', ['user' => $user, 'articles' => $lesArticles]);
    }

    public function rechercherArticles(Request $request)
    {
        $motCle = $request->input('search');
        $idCategorie = $request->input('category');
        $idTag = $request->input('tag');

        $requeteAuteurs = User::query();

        $requeteAuteurs->whereHas('articles', function($q) use ($motCle, $idCategorie, $idTag) {
            $q->where('draft', false);
            if ($motCle) {
                $q->where(function($sub) use ($motCle) {
                    $sub->where('title', 'like', "%{$motCle}%")
                      ->orWhere('content', 'like', "%{$motCle}%");
                });
            }
            if ($idCategorie) {
                $q->whereHas('categories', function($sub) use ($idCategorie) {
                    $sub->where('categories.id', $idCategorie);
                });
            }
            if ($idTag) {
                $q->whereHas('tags', function($sub) use ($idTag) {
                    $sub->where('tags.id', $idTag);
                });
            }
        });

        $lesUtilisateurs = $requeteAuteurs->with(['articles' => function($q) use ($motCle, $idCategorie, $idTag) {
            $q->where('draft', false);
            if ($motCle) {
                $q->where(function($sub) use ($motCle) {
                    $sub->where('title', 'like', "%{$motCle}%")
                      ->orWhere('content', 'like', "%{$motCle}%");
                });
            }
            if ($idCategorie) {
                $q->whereHas('categories', function($sub) use ($idCategorie) {
                    $sub->where('categories.id', $idCategorie);
                });
            }
            if ($idTag) {
                $q->whereHas('tags', function($sub) use ($idTag) {
                    $sub->where('tags.id', $idTag);
                });
            }
            $q->latest();
        }])->paginate(10)->withQueryString();

        $categories = Category::all();
        $tags = Tag::all();

        return view('public.archives', ['users' => $lesUtilisateurs, 'categories' => $categories, 'tags' => $tags]);
    }
}
