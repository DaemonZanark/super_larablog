<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //

    public function show()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->get();
        return view('articles.show', ['articles' => $articles]);
    }

    public function create()
    {   
        return view('articles.create');
    }
    public function store(Request $request)
    {
        
        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Créateur de l'article (auteur)
        $data['user_id'] = Auth::user()->id;

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On crée l'article
        $article = Article::create($data); // $Article est l'objet article nouvellement créé

        // Exemple pour ajouter la catégorie 1 à l'article
        //$article->categories()->sync(1);

        // Exemple pour ajouter des catégories à l'article
        //$article->categories()->sync([1, 2, 3]);

        // Exemple pour ajouter des catégories à l'article en venant du formulaire
        //$article->categories()->sync($request->input('categories'));

        // On redirige l'utilisateur vers la liste des articles
        return redirect()->route('articles.show');
    }

    public function edit(Article $article)
    {
        if($article->user_id !== Auth::user()->id)
        {
            abort(403, "Problème d'edit");
        }

        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        if($article->user_id !== Auth::user()->id)
        {
            abort(403, "Problème d'update");
        }
        $data = $request->only(['title', 'content', 'draft']);
        $data['draft'] = isset($data['draft']) ? 1 : 0;
        $article->update($data);
        return redirect()->route('articles.show')->with('success', 'Article mise à jour !');
    }
}
