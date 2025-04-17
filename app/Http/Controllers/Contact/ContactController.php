<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        return view('pages.contact');
    }

    public function student(){
        // if(!Gate::allows('view-contact-student')){ abort(403); }
        return view('contact.student.index');
    }

    public function teacher(){
        return view('contact.teacher.index');
    }

    public function department(){
        return view('contact.department.index');
    }
}
