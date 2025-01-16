@extends('layouts.videos-app')

@section('content')
    <h1>Benvingut a VideosApp</h1>
    <p>Aquesta és la pàgina principal de l'aplicació.</p>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('videos.index') }}">Videos</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
        </ul>
    </nav>
@endsection
