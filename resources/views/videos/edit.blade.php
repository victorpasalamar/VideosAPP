@extends('layouts.videos-app')

@section('content')
    <h1>Edita el vídeo: {{ $video->title }}</h1>

    <form action="{{ route('videos.update', $video->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Utilitzem PUT per actualitzar el recurs -->

        <div class="form-group">
            <label for="title">Títol</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $video->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripció</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $video->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="url">URL del vídeo</label>
            <input type="url" class="form-control" id="url" name="url" value="{{ old('url', $video->url) }}" required>
        </div>

        <div class="form-group">
            <label for="published_at">Data de publicació</label>
            <input type="date" class="form-control" id="published_at" name="published_at" value="{{ old('published_at', $video->published_at->format('Y-m-d')) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Desar els canvis</button>
    </form>

    <a href="{{ route('videos.index') }}" class="btn btn-secondary mt-3">Tornar a la llista de vídeos</a>
@endsection
