<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if admin is authenticated using session
        if (!session()->has('admin_user')) {
            // If not authenticated, redirect to admin login
            return redirect()->route('admin_login.view')->with('error', 'Please login to access admin panel');
        }

        // If authenticated, continue to the requested page
        return $next($request);
    }
}
