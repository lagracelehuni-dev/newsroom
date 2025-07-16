<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstname = $this->faker->firstName;
        $lastname = $this->faker->lastName;

        // Génère un username unique basé sur prénom+nom
        $username = Str::slug($firstname . $lastname . rand(1, 99));
        $suffix = 1;
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = Str::slug($firstname . $lastname) . $suffix++;
        }

        return [
            'first_name' => $firstname,
            'last_name' => $lastname,
            'username' => $username,
            'email' => $username . '@example.com',
            'password' => Hash::make('123456'), // mot de passe par défaut
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($firstname . ' ' . $lastname) . '&background=random&size=128'
        ];
    }
}
