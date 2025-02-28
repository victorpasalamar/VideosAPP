<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideosApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<header>
    <nav>
        VIDEOSAPP<p></p>
        <a href="{{ route('videos.index') }}" class="btn btn-secondary mt-3">Tornar a la llista de vídeos</a><p></p>
    </nav>
</header>

<main>
    @yield('content') <!-- Aquí s'inserirà el contingut de la vista específica -->
</main>

<footer>
    <p>&copy; {{ date('Y') }} VideosApp</p>
</footer>
</body>
</html>
