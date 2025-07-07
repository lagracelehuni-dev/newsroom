<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UsersFromArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(public_path('data/articles.json'));
        $data = json_decode($json, true);
        if (!isset($data['articles'])) return;

        $authors = collect();
        foreach ($data['articles'] as $catData) {
            foreach ($catData['articles'] as $article) {
                if (!empty($article['author_name'])) {
                    $authors->push($article['author_name']);
                }
            }
        }
        $authors = $authors->unique();

        foreach ($authors as $author) {
            $parts = explode(' ', $author, 2);
            $firstName = $parts[0] ?? $author;
            $lastName = $parts[1] ?? '';
            $username = Str::limit(Str::slug($author), 50, '');
            User::firstOrCreate([
                'username' => $username
            ], [
                'email' => $username . '@example.com',
                'password' => bcrypt('123456'),
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }
    }
}
