<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video; // Importem el model Video

class VideosTest extends TestCase
{
use RefreshDatabase;
/**
* Comprovar que es pot obtenir la data formatada correctament.
*
* @return void
*/
public function test_can_get_formatted_published_at_date()
{
// Creem un vídeo amb una data de publicació
$video = Video::create([
'title' => 'Video de Prova',
'description' => 'Descripció del vídeo de prova',
'url' => 'http://example.com/video.mp4',
'published_at' => now(), // Data de publicació actual
]);

// Comprovem que el vídeo té la data publicada formatada correctament
$this->assertEquals($video->getFormattedPublishedAtAttribute(), now()->isoFormat('D [de] MMMM [de] YYYY'));
}
/**
* Comprovar el comportament quan no hi ha data de publicació.
*
* @return void
*/
public function test_can_get_formatted_published_at_date_when_not_published()
{
// Creem un vídeo sense data de publicació
$video = Video::create([
'title' => 'Video de Prova',
'description' => 'Descripció del vídeo de prova',
'url' => 'http://example.com/video.mp4',
'published_at' => null, // Sense data de publicació
]);
// Comprovem que la data publicada formatada és null
$this->assertNull($video->getFormattedPublishedAtAttribute());
}
}
