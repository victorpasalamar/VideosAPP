<?php

namespace App\Helpers;

use App\Models\Video;
use Carbon\Carbon;

class VideoHelper
{
    public static function createDefaultVideo1($title = 'Vídeo per defecte')
    {
        return Video::create([
            'title' => $title,
            'description' => 'Descripció per defecte del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=MLm2xR1kl70', // Enllaç de vídeo aleatori.
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => null,
            'series_id' => null
        ]);
    }
    public static function createDefaultVideo2($title = 'Vídeo per defecte')
    {
        return Video::create([
            'title' => $title,
            'description' => 'Descripció per defecte del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=8ZEgML4sg-4', // Enllaç de vídeo aleatori.
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => null,
            'series_id' => null
        ]);
    }
    public static function createDefaultVideo3($title = 'Vídeo per defecte')
    {
        return Video::create([
            'title' => $title,
            'description' => 'Descripció per defecte del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=K8NKNKub2HI', // Enllaç de vídeo aleatori.
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => null,
            'series_id' => null
        ]);
    }
    public static function createDefaultVideo4($title = 'Vídeo per defecte')
    {
        return Video::create([
            'title' => $title,
            'description' => 'Descripció per defecte del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=Pl8hZjsGMa4', // Enllaç de vídeo aleatori.
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => null,
            'series_id' => null
        ]);
    }
    public static function createDefaultVideo5($title = 'Vídeo per defecte')
    {
        return Video::create([
            'title' => $title,
            'description' => 'Descripció per defecte del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=WXNoG2kI0f0', // Enllaç de vídeo aleatori.
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => null,
            'series_id' => null
        ]);
    }


}
