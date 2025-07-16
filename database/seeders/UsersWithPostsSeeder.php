<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class UsersWithPostsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Création des catégories si elles n'existent pas déjà
        $categories = [
            'art-design' => 'Art & Design',
            'cybersecurite' => 'Cybersécurité',
            'economie' => 'Économie',
            'entrepreneuriat' => 'Entrepreneuriat',
            'films-series' => 'Films & Séries',
            'musique' => 'Musique',
            'jeux-video' => 'Jeux Vidéo',
            'sport' => 'Sport',
            'politique' => 'Politique',
            'international' => 'International',
            'societe' => 'Société',
            'sante' => 'Santé',
            'mode-beaute' => 'Mode & Beauté',
            'voyage' => 'Voyage'
        ];

        foreach ($categories as $slug => $name) {
            Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }

        $categoryIds = Category::pluck('id')->toArray();
        $allUsers = User::factory(100)->create();

        // Génère les utilisateurs, articles, commentaires, réponses, likes et signets
        $allUsers->each(function ($user) use ($categoryIds, $faker, $allUsers) {
            // Chaque utilisateur a entre 0 à 50 articles
            Post::factory(rand(0, 10))->create([
                'user_id' => $user->id,
                'category_id' => $faker->randomElement($categoryIds),
                'cover_image' => 'https://picsum.photos/800/400?random=' . rand(1, 100), // image factice
            ])->each(function ($post) use ($faker, $allUsers) {
                // Ajoute entre 0 et 30 commentaires d'autres utilisateurs
                $commenters = $allUsers->shuffle()->take(rand(0, 10));
                foreach ($commenters as $commenter) {
                    $comment = Comment::factory()->create([
                        'user_id' => $commenter->id,
                        'post_id' => $post->id,
                        'content' => $faker->paragraph(),
                    ]);

                    // Ajoute entre 0 et 5 réponses à ce commentaire
                    $repliers = $allUsers->shuffle()->take(rand(0, 5));
                    foreach ($repliers as $replier) {
                        Comment::factory()->create([
                            'user_id' => $replier->id,
                            'post_id' => $post->id,
                            'parent_id' => $comment->id,
                            'content' => $faker->sentence(),
                        ]);
                    }
                }

                //Ajoute des vues au post
                $viewers = $allUsers->shuffle()->take(rand(0, 100));
                $post->increment('views_count', $viewers->count());

                // Ajoute des likes au post
                $likers = $allUsers->shuffle()->take(rand(0, 100));
                foreach ($likers as $liker) {
                    $post->likes()->create([
                        'user_id' => $liker->id,
                    ]);
                }

                // Ajoute des signets (bookmarks)
                $bookmarkers = $allUsers->shuffle()->take(rand(0, 5));
                foreach ($bookmarkers as $bookmarkingUser) {
                    $bookmarkingUser->bookmarks()->attach($post->id);
                }
            });
        });
    }
}
