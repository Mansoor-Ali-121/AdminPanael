<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // User not logged in or not an admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return Redirect::route('user.login');
        }

        return $next($request);
    }
}
