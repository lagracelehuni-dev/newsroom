<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        // 30% de chance que le commentaire ait une image
        $hasImage = $this->faker->boolean(30);

        return [
            'content' => $this->faker->realText(200),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'parent_id' => null,
            'image' => $hasImage
                ? 'https://picsum.photos/seed/' . uniqid() . '/640/480'
                : null,
        ];
    }
}
