<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIdentified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_email')) {
            return redirect()->route('password.identify')
                ->withErrors(['email' => 'Veuillez d’abord rechercher votre compte.']);
        }

        return $next($request);
    }
}
