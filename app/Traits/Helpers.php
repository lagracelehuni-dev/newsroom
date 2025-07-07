<?php

namespace App\Traits;
use Carbon\Carbon;

trait Helpers
{
    

    /**
     * Format a date to a human-readable string.
     *
     * @param Carbon|null $date
     * @return string
     */
    function stripped_date(?Carbon $date): string
    {
        if (!$date) return '';
        $now = Carbon::now();
        $diffInSeconds = $date->diffInSeconds($now);

        if ($diffInSeconds < 30) return 'À l’instant';
        if ($diffInSeconds < 60) return $diffInSeconds . 's';
        if ($diffInSeconds < 3600) return $date->diffInMinutes($now) . 'm';
        if ($diffInSeconds < 86400) return $date->diffInHours($now) . 'h';
        if ($date->isYesterday()) return 'Hier à ' . $date->format('H:i');
        if ($date->isCurrentWeek()) return $date->translatedFormat('l') . ' à ' . $date->format('H:i');
        if ($date->isCurrentYear()) return $date->translatedFormat('j F') . ' à ' . $date->format('H:i');
        
        return $date->translatedFormat('j F Y');
    }

}
