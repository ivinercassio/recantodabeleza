<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Verific {
    public function handle ($request, Closure $next){
        if(!Auth::check()){
            return redirect()->route('login');
        }else{
            return $next($request);
        }
    }
}