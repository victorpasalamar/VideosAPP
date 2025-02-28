@extends('layouts.videos-app')

@section('content')
    <h1>Eliminar vídeo</h1>

    <p>Segur que vols eliminar el vídeo <strong>{{ $video->title }}</strong>?</p>

    <form action="{{ route('videos.destroy', $video->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        <a href="{{ route('videos.index') }}" class="btn btn-secondary">Cancel·lar</a>
    </form>
@endsection
