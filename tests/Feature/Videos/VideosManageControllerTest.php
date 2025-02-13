<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa que l'usuari amb els permisos apropiats pugui gestionar vídeos.
     */
    public function test_user_with_permissions_can_manage_videos()
    {
        $user = $this->loginAsVideoManager(); // Usuari amb permís de video_manager
        $video = Video::factory()->create(); // Crear un vídeo de prova

        $response = $this->actingAs($user)->get(route('videos.index', $video->id));

        $response->assertStatus(200);
        $response->assertViewIs('videos.index'); // Assegura't que es carrega la vista esperada
    }

    /**
     * Testa que els usuaris regulars no poden gestionar vídeos.
     */
    public function test_regular_users_cannot_manage_videos()
    {
        $user = $this->loginAsRegularUser(); // Usuari sense permisos
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->get(route('videos.edit', $video->id));

        $response->assertStatus(500); // Forbidden, no tenen permisos
    }

    /**
     * Testa que els usuaris guest no poden gestionar vídeos.
     */
    public function test_guest_users_cannot_manage_videos()
    {
        $video = Video::factory()->create();

        $response = $this->get(route('videos.edit', $video->id)); // Usuari guest sense autenticació

        $response->assertRedirect(route('login')); // Ha de redirigir a la pàgina de login
    }

    /**
     * Testa que el superadmin pot gestionar vídeos.
     */
    public function test_superadmins_can_manage_videos()
    {
        $user = $this->loginAsSuperAdmin(); // Usuari super_admin
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->get(route('videos.index', $video->id));

        $response->assertStatus(200);
        $response->assertViewIs('videos.index');
    }

    /**
     * Simula el login com a Video Manager.
     */
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

    /**
     * Simula el login com a Super Admin.
     */
    private function loginAsSuperAdmin()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);

        $role = Role::firstOrCreate(['name' => 'super_admin']);
        $user->assignRole($role);

        return $user;
    }

    /**
     * Simula el login com a Regular User.
     */
    private function loginAsRegularUser()
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'regular@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);

        $role = Role::firstOrCreate(['name' => 'regular_user']);
        $user->assignRole($role);

        return $user;
    }

    /**
     * Testa la formatació de la data de publicació del vídeo.
     */
    public function test_video_published_at_is_formatted_correctly()
    {
        $video = Video::factory()->create([
            'published_at' => Carbon::create(2025, 1, 13, 10, 0, 0),
        ]);

        $formattedDate = $video->formattedPublishedAt; // Format "13 de gener de 2025"
        $this->assertEquals('13 de gener de 2025', $formattedDate);

        $formattedForHumans = $video->formattedForHumansPublishedAt; // Format "fa 2 hores"
        $this->assertStringContainsString('fa', $formattedForHumans); // Per exemple, "fa 2 hores"
    }
}
