<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OrganiserAuth
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
        if(Auth::user()->role!=="Organiser" and Auth::user()->is_org==0){
            $request->session()->flash('error', "Please login as a Trainer to access this content");
            return redirect()->route('home');
        }
        return $next($request);
    }
}
