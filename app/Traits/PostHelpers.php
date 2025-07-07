<?php

namespace App\Traits;
use App\Models\Post;

trait PostHelpers
{
    
    // Calcul du temps de lecture pour un contenu donné (méthode statique)
    public static function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $wordsPerMinute = 200;
        return max(1, ceil($wordCount / $wordsPerMinute));
    }
}
