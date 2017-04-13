<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class Admin
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
        if (Auth::check()) {
            # check user 
            if (Auth::user()->isAdmin()) {
                # check user is Admin then return next request
                return $next($request);
            }

        }
        // return redirect('errors.404');
        return redirect('/');
        
    }
}
