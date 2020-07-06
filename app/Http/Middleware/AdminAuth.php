<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
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
        if ($request->session()->exists('auth') && !session('auth')) {
            return redirect('login')->with('status', 'Please login to access that page');
        } else {
            return $next($request);
        }
    }
}
