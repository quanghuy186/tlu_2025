<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pest\Support\View;
use Artesaos\SEOTools\Facades\SEOTools as SEO;

class RegisterController extends Controller
{
    public function index(){
        SEO::setTitle('Đăng ký - Hệ thống tra cứu và trao đổi thông tin nội bộ TLU');
        return View('auth.register');
    }
}