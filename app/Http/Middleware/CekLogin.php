<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekLogin
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (Auth::user()->role == $roles) {
            return $next($request);
        } else {
            return redirect('/dashboard');
        }
    }
}
