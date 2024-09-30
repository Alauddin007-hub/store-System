<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // $loggedRole = Auth::user()->user_type;

            if (Auth::user()->user_type_id == 1) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login');
            }
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
