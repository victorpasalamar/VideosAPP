<?php

namespace Tests\Feature\Videos;

use App\Helpers\VideoHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
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

    public function test_user_without_permissions_can_see_default_videos_page()
    {
        // Creem un usuari sense permisos específics
        $user = User::factory()->create();

        // Creem alguns vídeos per verificar que es mostren
        VideoHelper::createDefaultVideo1('Video 1');
        VideoHelper::createDefaultVideo2('Vídeo 2');
        VideoHelper::createDefaultVideo3('Vídeo 3');

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Comprovem que l'usuari pot veure la pàgina de vídeos
        $response = $this->get(route('videos.index'));

        // Comprovem que la vista es carrega correctament (status 200)
        $response->assertStatus(200);

        // Comprovem que els títols dels vídeos es mostren a la vista
        $response->assertSee('Video 1');
        $response->assertSee('Vídeo 2');
        $response->assertSee('Vídeo 3');
    }

    public function test_user_with_permissions_can_see_default_videos_page()
    {
        // Creem un usuari amb permisos específics (suposem que el permís es gestiona per un sistema de rols)
        $user = $this->loginAsVideoManager(); // Usuari amb permís de video_manager


        // Creem alguns vídeos per verificar que es mostren
        VideoHelper::createDefaultVideo1('Video 1');
        VideoHelper::createDefaultVideo2('Vídeo 2');
        VideoHelper::createDefaultVideo3('Vídeo 3');

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Comprovem que l'usuari amb permís pot veure la pàgina de vídeos
        $response = $this->get(route('videos.index'));

        // Comprovem que la vista es carrega correctament (status 200)
        $response->assertStatus(200);

        // Comprovem que els títols dels vídeos es mostren a la vista
        $response->assertSee('Video 1');
        $response->assertSee('Vídeo 2');
        $response->assertSee('Vídeo 3');
    }

    private function loginAsVideoManager()
    {
        $user = User::create([
            'name' => 'Video Manager Proma',
            'email' => 'videosmanagerprova@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);
        $role = Role::firstOrCreate(['name' => 'video_manager']);
        $user->assignRole($role);
        return $user;
    }

    public function test_not_logged_users_can_see_default_videos_page()
    {
        // Creem alguns vídeos per verificar que es mostren
        VideoHelper::createDefaultVideo1('Video 1');
        VideoHelper::createDefaultVideo2('Vídeo 2');
        VideoHelper::createDefaultVideo3('Vídeo 3');

        // Simulem que l'usuari no està loguejat (no cal cridar a actingAs)

        // Comprovem que un usuari no loguejat pot veure la pàgina de vídeos
        $response = $this->get(route('videos.index'));

        // Comprovem que la vista es carrega correctament (status 200)
        $response->assertStatus(200);

        // Comprovem que els títols dels vídeos es mostren a la vista
        $response->assertSee('Video 1');
        $response->assertSee('Vídeo 2');
        $response->assertSee('Vídeo 3');
    }
}
