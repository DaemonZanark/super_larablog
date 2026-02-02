<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Notifications\NewCommentNotification;
use App\Notifications\NewLikeNotification;
use App\Notifications\NewArticleNotification;
use App\Notifications\NewFollowerNotification;

class UserController extends Controller
{


    public function dashboard()
    {
        $user = Auth::user();

        $totalArticles = $user->articles()->count();
        $sommeLikes = $user->articles()->withCount('likes')->get()->sum('likes_count');
        $sommeCommentaires = $user->articles()->withCount('comments')->get()->sum('comments_count');

        $articlesRecents = $user->articles()->latest()->take(5)->get();

        $dates = collect();
        $donneesLikes = collect();
        $donneesCommentaires = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates->push(now()->subDays($i)->translatedFormat('d M'));

            $likesCount = \Illuminate\Support\Facades\DB::table('article_user')
                ->whereIn('article_id', $user->articles()->pluck('id'))
                ->whereDate('created_at', $date)
                ->count();
            $donneesLikes->push($likesCount);

            $commentsCount = Comment::whereIn('article_id', $user->articles()->pluck('id'))
                ->whereDate('created_at', $date)
                ->count();
            $donneesCommentaires->push($commentsCount);
        }

        return view('dashboard', compact(
            'totalArticles',
            'sommeLikes',
            'sommeCommentaires',
            'articlesRecents',
            'dates',
            'donneesLikes',
            'donneesCommentaires'
        ));
    }

    public function show()
    {
        $user = Auth::user();
        $articles = Article::with(['categories', 'comments', 'likes'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('articles.show', ['articles' => $articles]);
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('articles.create', compact('categories', 'tags'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'array',
            'tags' => 'array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $inputs = $request->only(['title', 'content', 'draft']);

        $inputs['slug'] = Str::slug($inputs['title']);

        $slugOriginal = $inputs['slug'];
        $compteur = 1;
        while (Article::where('slug', $inputs['slug'])->exists()) {
            $inputs['slug'] = $slugOriginal . '-' . $compteur++;
        }

        if ($request->hasFile('image')) {
            $chemin = $request->file('image')->store('articles', 'public');
            $inputs['image'] = $chemin;
        }

        $inputs['user_id'] = Auth::user()->id;

        $inputs['draft'] = $request->has('draft');

        $article = Article::create($inputs);

        if ($request->has('categories')) {
            $article->categories()->sync($request->input('categories'));
        }
        if ($request->has('tags')) {
            $article->tags()->sync($request->input('tags'));
        }

        if (!$article->draft) {
            foreach (Auth::user()->followers as $follower) {
                $follower->notify(new NewArticleNotification($article));
            }
        }

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès !');
    }

    public function edit(Article $article)
    {
        if($article->user_id !== Auth::user()->id)
        {
            abort(403, "Vous n'êtes pas autorisé à modifier cet article.");
        }

        $categories = Category::all();
        $tags = Tag::all();

        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        if($article->user_id !== Auth::user()->id)
        {
            abort(403, "Action non autorisée.");
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'array',
            'tags' => 'array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $champs = $request->only(['title', 'content', 'draft']);
        $champs['draft'] = $request->has('draft');

        if ($article->title !== $champs['title']) {
            $champs['slug'] = Str::slug($champs['title']);
            $slugInitial = $champs['slug'];
            $compteur = 1;
            while (Article::where('slug', $champs['slug'])->where('id', '!=', $article->id)->exists()) {
                $champs['slug'] = $slugInitial . '-' . $compteur++;
            }
        }

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $chemin = $request->file('image')->store('articles', 'public');
            $champs['image'] = $chemin;
        }

        $article->update($champs);

        $article->categories()->sync($request->input('categories', []));
        $article->tags()->sync($request->input('tags', []));

        return redirect()->route('articles.index')->with('success','Article mis à jour !');
    }

    public function supprimerArticle(?Article $article)
    {
        if($article->user_id == Auth::user()->id)
        {
            $article->delete();
        } else {
            return redirect()->route('articles.index')->with('error', "Vous n'êtes pas autorisé à supprimer cet article");
        }

        return redirect()->route('articles.index')->with('success', 'Article supprimé !');
    }

    public function publierCommentaire(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $commentaire = $article->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'),
        ]);

        if ($article->user_id !== Auth::id()) {
            $article->user->notify(new NewCommentNotification($commentaire));
        }

        return back()->with('success', 'Commentaire ajouté !');
    }

    public function aimerArticle(Article $article)
    {
        $utilisateur = Auth::user();

        $utilisateur->likes()->attach($article->id);

        if ($article->user_id !== Auth::id()) {
            $article->user->notify(new NewLikeNotification($article, $utilisateur));
        }

        return back();
    }

    public function suivreAuteur(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', "Vous ne pouvez pas vous abonner à vous-même.");
        }

        $resultat = Auth::user()->following()->toggle($user->id);

        if (count($resultat['attached']) > 0) {
            $user->notify(new NewFollowerNotification(Auth::user()));
        }

        return back();
    }

    public function supprimerCommentaire(Comment $comment)
    {
        if ($comment->user_id === Auth::id() || $comment->article->user_id === Auth::id()) {
            $comment->delete();
            return back()->with('success', 'Commentaire supprimé.');
        }

        abort(403, "Vous n'avez pas l'autorisation de supprimer ce commentaire.");
    }
}
