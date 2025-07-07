<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $title = $this->faker->sentence(6, true);
        $content = collect($this->faker->paragraphs(rand(3, 7)))->map(fn($p) => "$p")->implode('');

        return [
            'title' => $title,
            'content' => $content,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'custom_slug' => false,
            'category_id' => random_int(1, 14),
            'reading_time' => ceil(str_word_count(strip_tags($content)) / 200),
            'custom_reading_time' => false,
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
