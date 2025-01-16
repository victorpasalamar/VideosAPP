<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    // Funció per mostrar la llista de vídeos
    public function index()
    {
        $videos = Video::all();  // Obtenim tots els vídeos
        return view('videos.index', compact('videos'));  // Retornem la vista amb els vídeos
    }
}
