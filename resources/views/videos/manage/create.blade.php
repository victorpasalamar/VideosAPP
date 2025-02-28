@extends('layouts.videos-app')

@section('content')
    <h1>Crear un nou vídeo</h1>

    <form action="{{ route('videos.store') }}" method="POST" data-qa="video-create-form">
        @csrf

        <div class="form-group">
            <label for="title" data-qa="title-label">Títol</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required data-qa="title-input">
        </div>

        <div class="form-group">
            <label for="description" data-qa="description-label">Descripció</label>
            <textarea class="form-control" id="description" name="description" rows="3" data-qa="description-input">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="url" data-qa="url-label">URL del vídeo</label>
            <input type="url" class="form-control" id="url" name="url" value="{{ old('url') }}" required data-qa="url-input">
        </div>

        <div class="form-group">
            <label for="published_at" data-qa="published-at-label">Data de publicació</label>
            <input type="date" class="form-control" id="published_at" name="published_at" value="{{ old('published_at', now()->format('Y-m-d')) }}" required data-qa="published-at-input">
        </div>

        <button type="submit" class="btn btn-success" data-qa="submit-button">Publicar vídeo</button>
    </form>

    <a href="{{ route('videos.index') }}" class="btn btn-secondary mt-3" data-qa="back-to-videos-list">Tornar a la llista de vídeos</a>
@endsection
