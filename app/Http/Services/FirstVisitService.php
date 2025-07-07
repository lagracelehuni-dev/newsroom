<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Session;

class FirstVisitService
{
    /**
     * Create a new class instance.
     */
    public function handleFirstVisit(): bool
    {
        if (!Session::has('visited')) {
            Session::put('visited', true);
            return true;
        }

        return false;
    }

    public function markVisited()
    {
        Session::put('visited', true);
    }

    public function resetVisited()
    {
        Session::forget('visited');
    }
}
