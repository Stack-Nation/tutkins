<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class KidAuth
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
        if(Auth::user()->role!=="Kid"){
            $request->session()->flash('error', "Please login as a Kid to access the content");
            return redirect()->route('home');
        }
        return $next($request);
    }
}
