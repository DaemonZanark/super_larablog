<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Random\RandomException;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(random_int(4, 8));

        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 99999),
            'content' => collect(fake()->paragraphs(random_int(6, 15)))
                ->map(fn ($p) => $p)
                ->implode(''),
            'image' => null,
            'draft' => fake()->boolean(15),
            'views_count' => fake()->numberBetween(0, 2500),
        ];
    }
}
