<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Random\RandomException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * @throws RandomException
     */
    public function run(): void
    {
        $categoryNames = [
            'Technologie',
            'I.A',
            'Informatique',
            'Atelier',
            'Développement',
            'Web',
            'Mobile',
            'Jeux vidéo',
            'Culture geek',
            'Hardware',
            'Cybersécurité',
            'Tutoriels',
            'Tests',
            'Actualités',
            'Productivité',
            'Open source',
            'Design',
            'Backend',
            'Frontend',
            'DevOps',
            'Festival',
            'Événements',
            'Conférences',
            'Scène indie',
            'Musique live',
            'Pop culture',
            'Cosplay',
            'Retrogaming',
        ];

        $tagNames = [
            'Laravel',
            'PHP',
            'Blazor',
            'MudBlazor',
            'CSharp',
            'Unity',
            'Docker',
            'API',
            'Sanctum',
            'MySQL',
            'Linux',
            'Windows',
            'UI',
            'UX',
            'SEO',
            'Performance',
            'Gaming',
            'Indie',
            'Festival',
            'Concert',
            'Workshop',
            'Starter Pack',
            'Review',
            'Tutoriel',
            'Backend',
            'Frontend',
            'Programmation',
            'OpenSource',
            'Cyber',
            'Streaming',
            'Arcade',
            'PixelArt',
            'Console',
            'Cloud',
            'DevBlog',
            'WebApp',
            'MobileDev',
            'Retro',
            'EventTech',
            'CreativeTech',
        ];

        foreach ($categoryNames as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        foreach ($tagNames as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }

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

        User::factory()->count(100)->create();

        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        $articleStarters = [
            'Pourquoi ',
            'Comment ',
            'Guide complet : ',
            'Top 10 ',
            'Découverte de ',
            'Retour sur ',
            'Les bases de ',
            'Bien démarrer avec ',
            'Focus sur ',
            'Analyse de ',
        ];

        $articleSubjects = [
            'Laravel pour les blogs modernes',
            'l’intelligence artificielle dans les festivals',
            'les ateliers créatifs pour développeurs',
            'le hardware pour les créateurs',
            'la scène indie gaming',
            'les tendances web de demain',
            'les outils IA pour gagner du temps',
            'les événements geeks incontournables',
            'le retrogaming en 2026',
            'les bonnes pratiques backend',
            'les expériences mobiles immersives',
            'la culture geek et les festivals',
            'les API Laravel sécurisées',
            'les performances frontend',
            'les conférences tech à suivre',
            'le cosplay et la pop culture numérique',
            'la création d’un blog tech',
            'les workflows DevOps simples',
            'les environnements Linux pour dev',
            'les projets créatifs autour du jeu vidéo',
        ];

        for ($i = 0; $i < 100; $i++) {
            $title = fake()->randomElement($articleStarters) . fake()->randomElement($articleSubjects);

            $article = Article::create([
                'user_id' => $users->random()->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 99999),
                'content' => collect(fake()->paragraphs(random_int(8, 16)))
                    ->map(fn ($p) => $p)
                    ->implode(''),
                'image' => null,
                'draft' => fake()->boolean(10),
                'views_count' => fake()->numberBetween(0, 3000),
            ]);

            $article->categories()->sync(
                $categories->random(random_int(1, 3))->pluck('id')->toArray()
            );

            $article->tags()->sync(
                $tags->random(random_int(2, 5))->pluck('id')->toArray()
            );
        }
    }
}
