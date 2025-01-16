<?php

namespace App\Helpers;

use App\Models\Video;
use Carbon\Carbon;

class VideoHelper
{
    public static function createDefaultVideo($title = 'Vídeo per defecte')
    {
        return Video::create([
            'title' => $title,
            'description' => 'Descripció per defecte del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Enllaç de vídeo aleatori.
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => null,
            'series_id' => null
        ]);
    }
}
