<?php

namespace App\Http\Controllers;
use Faker\Factory as Faker;

use Illuminate\Http\Request;

class AnonymeController extends Controller
{
    //
    public function Anonyme ()
    {
        $faker = Faker::create();
        $users = [];
        $posts = [];
        $texts = ['text' => $faker->words(rand(1000, 2000), true)];

        // Nombre d'articles à générer
        $numArticles = 5;

        // Nombre de commentaires à générer
        $numComments = 5;

        for ($i = 0; $i < $numArticles; $i++) {

            $ctg = null;
            $val = random_int(0, 4);

            if ($val == 0) {
                $ctg = "art&design";
                $imageNumber = random_int(1, 5);

            } elseif ($val == 1) {
                $ctg = "cybersecurite";
                $imageNumber = random_int(1, 5);

            } elseif ($val == 2) {
                $ctg = "economie";
                $imageNumber = random_int(1, 5);

            } elseif ($val == 3) {
                $ctg = "entrepreneuriat";
                $imageNumber = random_int(1, 5);

            } else {
                $ctg = "films&series";
                $imageNumber = random_int(1, 5);

            }

            // $isMale = random_int(0, 1) != 0;
            // $gender = $isMale ? 'male' : 'female';



            // $imageNumber = $val ? random_int(1, 92) : random_int(1, 5);
            $imagePath = asset("assets/img/article/{$ctg}/{$ctg}__ ({$imageNumber}).jpg");

            // Stocker chaque article dans le tableau
            $posts[] = [
                'image' => $imagePath,
                'tag' => $ctg,
            ];
        }

        for ($i = 0; $i < $numComments; $i++) {
            $isMale = random_int(0, 1) != 0;
            $gender = $isMale ? 'male' : 'female';
            $avatarNumber = $isMale ? random_int(1, 92) : random_int(1, 53);
            $avatarPath = asset("assets/img/avatar/avatar_{$gender} ({$avatarNumber}).jpg");

            // Stocker chaque utilisateur dans le tableau
            $users[] = [
                'avatar' => $avatarPath,
                'name' => $isMale ? $faker->firstNameMale . ' ' . $faker->lastName : $faker->firstNameFemale . ' ' . $faker->lastName,
                'comment' => $faker->words(rand(1, 300), true),
                'comment' => $faker->words(rand(1, 300), true),
            ];
        }

        return view('main.pages.article_details', compact('users', 'posts'));
    }
}
