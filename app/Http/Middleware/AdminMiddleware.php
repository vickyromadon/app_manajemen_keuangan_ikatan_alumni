<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
        if (Auth::user()->roles[0]->name != "alumni" ) {
            return $next($request);
        } else {
            Auth::guard('web')->logout();
            abort(403, 'Unauthorized action.');
        }
    }
}
