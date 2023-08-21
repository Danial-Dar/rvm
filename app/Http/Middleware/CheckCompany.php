<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckCompany
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
         // If company is not logged in
         if(auth()->user() == null){
            Auth::logout();
            return redirect('/login');
         }
         if (auth()->user()->role != "company") {
            Auth::logout();
            return redirect('/login');
        }
        return $next($request);
    }
}
