<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogLoadSeeder extends Seeder
{
    public function run(): void
    {
        // 1 admin fixe
        User::firstOrCreate(
            ['email' => 'gpadmin@proton.me'],
            [
                'name' => 'gp_admin',
                'password' => 'password',
                'is_admin' => 1,
                'bio' => 'Administrateur principal de GeekPlace.',
                'avatar' => null,
            ]
        );

        // Utilisateurs
        $users = User::factory()->count(100)->create();

        // Catégories
        $categories = Category::factory()->count(20)->create();

        // Tags
        $tags = Tag::factory()->count(30)->create();

        // Articles
        $articles = Article::factory()->count(100)->create();

        // Relations many-to-many
        $articles->each(function (Article $article) use ($categories, $tags, $users) {
            if (!$article->user_id) {
                $article->update([
                    'user_id' => $users->random()->id,
                ]);
            }

            $article->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            $article->tags()->attach(
                $tags->random(rand(2, 5))->pluck('id')->toArray()
            );
        });

        // Quelques abonnements auteur/utilisateur
        $allUsers = User::all();

        $allUsers->each(function (User $user) use ($allUsers) {
            $authorsToFollow = $allUsers
                ->where('id', '!=', $user->id)
                ->random(min(rand(0, 5), max(0, $allUsers->count() - 1)));

            foreach (collect($authorsToFollow) as $author) {
                $user->following()->syncWithoutDetaching([$author->id]);
            }
        });

        // Quelques likes
        $articles = Article::all();

        $articles->each(function (Article $article) use ($allUsers) {
            $likers = $allUsers->random(rand(0, min(15, $allUsers->count())));
            $article->likes()->syncWithoutDetaching(collect($likers)->pluck('id')->toArray());
        });
    }
}
