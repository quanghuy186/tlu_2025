<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        return view('contact.index');
    }

    public function student(){
        return view('contact.student.index');
    }

    public function teacher(){
        return view('contact.teacher.index');
    }

    public function department(){
        return view('contact.department.index');
    }
}
