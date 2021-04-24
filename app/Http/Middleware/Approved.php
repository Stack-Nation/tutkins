<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Approved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if((Auth::user()->role=="Trainer" || Auth::user()->role=="Organiser") and Auth::user()->approved===0){
            return redirect()->route('user.not-verified');
        }
        return $next($request);
    }
}
