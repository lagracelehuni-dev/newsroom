<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\CategoryFactory;
use Database\Factories\PostFactory;
use Database\Factories\UserFactory;
use Illuminate\Container\Attributes\Auth;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(30)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call([
            UsersWithPostsSeeder::class,
        ]);
    }
}
