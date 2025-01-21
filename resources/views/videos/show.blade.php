@extends('layouts.videos-app')

@section('content')
    <h1>{{ $video->title }}</h1>
    <p>{{ $video->description }}</p>

    @if ($video->url)
        @if (Str::contains($video->url, 'youtube.com') || Str::contains($video->url, 'youtu.be'))
            @php
                $videoEmbedUrl = '';
                if (Str::contains($video->url, 'youtube.com')) {
                    $videoEmbedUrl = str_replace('watch?v=', 'embed/', $video->url);
                } elseif (Str::contains($video->url, 'youtu.be')) {
                    $videoEmbedUrl = 'https://www.youtube.com/embed/' . substr($video->url, strrpos($video->url, '/') + 1);
                }
            @endphp
            <iframe
                width="560"
                height="315"
                src="{{ $videoEmbedUrl }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        @else
            <video src="{{ $video->url }}" controls width="640" height="360">
                El teu navegador no suporta la reproducció de vídeos.
            </video>
        @endif
    @else
        <p>No hi ha cap vídeo disponible per mostrar.</p>
    @endif
@endsection
