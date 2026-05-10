<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(random_int(1, 2), true),
        ];
    }
}
