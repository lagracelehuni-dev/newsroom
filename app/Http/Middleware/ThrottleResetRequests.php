<?php

namespace App\Http\Middleware;

use Illuminate\Support\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleResetRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $email = $request->email;

        $lastRequest = DB::table('password_resets')
            ->where('email', $email)
            ->orderByDesc('created_at')
            ->first();

        if ($lastRequest && Carbon::parse($lastRequest->created_at)->addMinutes(2)->isFuture()) {
            return back()->with([
                'type' => 'info',
                'content' => 'Vous venez déjà de demander un code. Veuillez patienter quelques minutes avant de réessayer.'
            ]);
        }

        return $next($request);
    }
}
