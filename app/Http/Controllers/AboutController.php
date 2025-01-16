<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    // Funció per mostrar la pàgina About
    public function index()
    {
        return view('about');  // Retornem la vista 'about'
    }
}
