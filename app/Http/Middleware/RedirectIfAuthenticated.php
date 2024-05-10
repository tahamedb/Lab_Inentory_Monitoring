<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::check()) {
            // If the user is authenticated, check if the session has expired
            if ($request->session()->has('_token')) {
                // Session is active, allow the request to continue
                return $next($request);
            } else {
                // Session has expired, redirect to the login page
                return redirect()->route('login');
            }
        }


        return $next($request);
    }
}
