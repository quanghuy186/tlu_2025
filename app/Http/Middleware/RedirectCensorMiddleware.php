<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectCensorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }
        $user = Auth::user();
        // $isCensor = $user->roles()->whereHas('role', function($query) {
        //     $query->where('role_name', 'censor');})->exists();
        $isCensor = hasRole(4, $user);
        if($isCensor) {
            return redirect()->route('home.index');
        }
        return $next($request);
    }
}
