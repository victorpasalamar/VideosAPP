<?php

namespace Tests\Feature\Videos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video;
use App\Models\User;

class VideosTest extends TestCase
{
use RefreshDatabase;

/**
* Comprovar que els usuaris poden veure vídeos existents.
*
* @return void
*/
public function test_users_can_view_videos()
{
// Creem un usuari
$user = User::factory()->create();

// Creem un vídeo
$video = Video::factory()->create();

// Simulem el login de l'usuari
$this->actingAs($user);

// Comprovem que l'usuari pot veure el vídeo
$response = $this->get(route('videos.show', $video->id));

// Comprovem que la vista es carrega correctament (status 200)
$response->assertStatus(200);

// També podem comprovar que el títol del vídeo es mostra
$response->assertSee($video->title);
}

/**
* Comprovar que els usuaris no poden veure vídeos inexistents.
*
* @return void
*/
public function test_users_cannot_view_not_existing_videos()
{
// Creem un usuari
$user = User::factory()->create();

// Simulem el login de l'usuari
$this->actingAs($user);

// Intentem accedir a un vídeo que no existeix
$response = $this->get(route('videos.show', 999)); // Utilitzem un ID que no existeix

// Comprovem que es retorna un error 404 (pàgina no trobada)
$response->assertStatus(404);
}
}
