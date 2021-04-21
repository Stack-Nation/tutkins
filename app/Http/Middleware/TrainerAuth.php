<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class TrainerAuth
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
        if(Auth::user()->role==="Trainer" or Auth::user()->is_trainer==1){
            return $next($request);
        }
        else{
            $request->session()->flash('error', "Please login as a Trainer to access this content");
            return redirect()->route('home');
        }
    }
}
