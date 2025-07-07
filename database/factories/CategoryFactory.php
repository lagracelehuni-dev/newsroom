<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Liste des catégories disponibles avec leurs configurations
     */
    private array $categories = [
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


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = array_rand($this->categories);
        return [
            'name' => $this->categories[$slug],
            'slug' => $slug,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
