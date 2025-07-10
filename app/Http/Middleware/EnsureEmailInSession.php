<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailInSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('email')) {
            return redirect()->route('password.identify')
                ->with([
                    'type' => 'danger',
                    'content' => 'Session expirée. Veuillez recommencer la procédure.'
                ]);
        }

        return $next($request);
    }
}
