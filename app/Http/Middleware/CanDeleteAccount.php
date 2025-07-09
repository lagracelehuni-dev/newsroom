<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanDeleteAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('can_delete_account') || session('can_delete_account') !== true) {
            return redirect()->route('home')->with([
                'type' => 'warning',
                'content' => "Accès non autorisé à la suppression de compte."
            ]);
        }

        // Une fois que l'utilisateur accède à la page, on supprime immédiatement la session
        session()->forget('can_delete_account');

        return $next($request);
    }
}
