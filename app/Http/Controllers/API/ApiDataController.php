<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForumPost; 

class ApiDataController extends Controller
{
     public function index(Request $request)
    {
        $token = $request->query('token');
        if ($token !== 'abc123') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $documents = ForumPost::all();

        $html = '';
        foreach ($documents as $doc) {
            $html .= "<h2>{$doc->title}</h2>\n<p>{$doc->content}</p>\n\n";
        }

        return response($html)->header('Content-Type', 'text/html');
    }
}
