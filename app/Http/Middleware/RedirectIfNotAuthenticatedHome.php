<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Import de la facade Auth

class RedirectIfNotAuthenticatedHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur n'est pas authentifié, on le redirige vers /home
        if (!Auth::check()) {
            return redirect('/home');
        }
        // Sinon, on continue la requête normalement
        return $next($request);
    }
}
