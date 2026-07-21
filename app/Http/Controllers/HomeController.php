<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('homeview');
    }

    public function about()
    {
        return view('aboutview');
    }
}
