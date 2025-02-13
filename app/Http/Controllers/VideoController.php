<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Mostrar la llista de vídeos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $videos = Video::all(); // Obtenim tots els vídeos
        return view('videos.index', compact('videos')); // Retornem la vista amb els vídeos
    }

    /**
     * Mostrar un vídeo específic.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $video = Video::findOrFail($id); // Busca el vídeo o retorna un error 404
        return view('videos.show', compact('video'));
    }

    /**
     * Funció de proves.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function testedBy()
    {
        return response()->json([
            'tested_by' => \Tests\Unit\VideosTest::class,
        ]);
    }
    public function edit($id)
    {
        $video = Video::findOrFail($id); // Busca el vídeo pel seu ID

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();


        if (!$user->hasPermissionTo('edit videos')) {
            abort(403);
        }
        return view('videos.edit', compact('video')); // Retorna la vista d'edició amb el vídeo
    }



    public function update(Request $request, $id)
    {
        $video = Video::find($id);

        if (!$video) {
            abort(404, 'Vídeo no trobat.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'published_at' => 'required|date',
        ]);

        // Actualitzem el vídeo amb les dades del formulari
        $video->update($request->all());

        // Redirigim a la vista del vídeo actualitzat
        return redirect()->route('videos.show', $video->id)
            ->with('success', 'Vídeo actualitzat correctament!');
    }


}
