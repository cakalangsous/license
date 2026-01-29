<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->locale) {
                app()->setLocale($user->locale);
            }

            if ($user->timezone) {
                config(['app.timezone' => $user->timezone]);
                date_default_timezone_set($user->timezone);
            }
        }

        return $next($request);
    }
}
