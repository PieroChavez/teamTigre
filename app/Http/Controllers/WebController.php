<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function home()
    {
        return view('web.home'); // nuestra página principal
    }

    public function informacion()
    {
        return view('web.informacion'); // página de información
    }
}
