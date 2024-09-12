<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->is_active === 0) {
            Auth::logout();
            return redirect()->route('login')->withErrors('Nalog nije aktivan.');
        }

        return $next($request);
    }
}
