<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * Mostrar un vídeo específic.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $video = Video::findOrFail($id);

        return view('videos.show', compact('video'));
    }

    /**
     * Lògica de proves, si escau.
     */
    public function testedBy()
    {
        // Aquesta funció és opcional i depèn de les necessitats de proves
        return response()->json(['message' => 'Lògica de proves aquí']);
    }
}
