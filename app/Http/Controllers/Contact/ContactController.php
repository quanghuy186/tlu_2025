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
        return view('pages.contact.student');
    }

    public function teacher(){
        return view('pages.contact.teacher');
    }

    public function department(){
        return view('pages.contact.department');
    }
}
