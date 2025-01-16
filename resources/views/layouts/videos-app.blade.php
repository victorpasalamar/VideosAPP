<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideosApp</title>
</head>
<body>
<header>
    <nav>
        <!-- Navbar -->
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
