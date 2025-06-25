<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }
        $user = Auth::user();
        $isAdmin = $user->roles()->whereHas('role', function($query) {
            $query->where('role_name', 'admin');})->exists();
        if ($isAdmin) {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
