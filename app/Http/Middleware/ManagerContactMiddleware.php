<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerContactMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = Auth::user();

        $isAdmin = $user->roles()->whereHas('role', function($query) {
            $query->where('role_name', 'admin');
        })->exists();

        $censor = $user->roles()->whereHas('role', function($query) {
            $query->where('role_name', 'kiem_duyet_vien');
        })->exists();

        $permission_manager_contact = tluHasPermission($user, 'manager-contact');

        if (!$isAdmin && !$permission_manager_contact ){
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập trang này.');
        }
        return $next($request);
        
    }
}
