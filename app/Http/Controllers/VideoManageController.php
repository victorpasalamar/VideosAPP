<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class VideoManageController extends Controller
{
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

    public function testedBy(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'tested_by' => \Tests\Feature\Videos\VideosManageControllerTest::class,
        ]);
    }


    public function edit($id)
    {
        $video = Video::findOrFail($id);

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->hasPermissionTo('edit videos')) {
            abort(403);
        }

        return View::make('videos.edit', compact('video'));
    }

    public function index()
    {
        $videos = Video::all();
        return View::make('videos.index', compact('videos'));
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
            'published_at' => 'required|date',
        ]);

        if (!auth()->user()->hasPermissionTo('manage videos')) {
            abort(403, 'No tens permís per crear vídeos.');
        }

        $video = Video::create($request->all());

        return redirect()->route('videos.show', $video->id)
            ->with('success', 'Vídeo creat correctament!');
    }

    public function delete($id)
    {

        $video = Video::findOrFail($id);

        if (!auth()->user()->hasPermissionTo('manage videos')) {
            abort(403, 'No tens permís per eliminar vídeos.');
        }

        return view('videos.manage.delete', compact('video'));
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        if (!auth()->user()->hasPermissionTo('manage videos')) {
            abort(403, 'No tens permís per eliminar vídeos.');
        }

        $video->delete();

        return redirect()->route('videos.index')
            ->with('success', 'Vídeo eliminat correctament!');
    }
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('manage videos')) {
            abort(403, 'No tens permís per crear vídeos.');
        }

        return view('videos.manage.create'); // Retorna la vista de creació
    }
}
