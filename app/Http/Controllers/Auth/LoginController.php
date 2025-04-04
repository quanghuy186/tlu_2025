<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools as SEO;

class LoginController extends Controller
{
    public function index(){
        SEO::setTitle('Đăng nhập - Hệ thống tra cứu và trao đổi thông tin nội bộ TLU');
        return view('auth.login');
    }

    public function showLoginForm(){
        return view('auth.login');
    }

}
