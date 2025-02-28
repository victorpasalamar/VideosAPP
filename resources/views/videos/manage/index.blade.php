@extends('layouts.videos-app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Llista de Vídeos</h1>

        <!-- Botó per crear un nou vídeo -->
        <a href="{{ route('videos.create') }}" class="btn btn-success mb-3">Crear nou vídeo</a>

        <div class="list-group">
            @foreach ($videos as $video)
                <div class="list-group-item d-flex justify-content-between align-items-center p-3 gap-2">
                    <div class="col mb-4">
                        <!-- Envoltar la card amb un link -->
                        <a href="{{ route('videos.show', $video->id) }}" class="text-decoration-none">
                            <div class="card h-30">
                                @php
                                    // Obtenir l'ID del vídeo de YouTube
                                    preg_match('/(?:\/|v=)([a-zA-Z0-9_-]{11})/', $video->url, $matches);
                                    $videoId = $matches[1] ?? null;
                                    // Crear l'URL de la miniatura de YouTube
                                    $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/$videoId/hqdefault.jpg" : null;
                                @endphp

                                    <!-- Miniatura del vídeo -->
                                @if ($thumbnailUrl)
                                    <img src="{{ $thumbnailUrl }}" class="card-img-top thumbnail-img img-fluid" alt="Miniatura del vídeo">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Miniatura+no+disponible" class="card-img-top thumbnail-img" alt="Miniatura per defecte">
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title text-dark">
                                        {{ $video->title }}
                                    </h5>
                                    <p class="card-text">{{ Str::limit($video->description, 100) }}</p>
                                </div>
                                <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                                    <span>{{ $video->published_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </a>
                    </div>


                    <!-- Accions (botons a la dreta) -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-primary btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('videos.destroy', $video->id) }}" method="POST"
                              onsubmit="return confirm('Segur que vols eliminar aquest vídeo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
<style>
    .card img {
        width: 400px;
    }
    .btn-sm {
        height: 38px;  /* Ajusta la mida si és necessari */
        padding: 0.375rem 0.75rem;  /* Padding de botó petit per a uniformitat */
    }
    </style>
