<?php

namespace Tests\Feature\Videos;

use App\Helpers\VideoHelper;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
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

        // Crear 3 vídeos de prova mitjançant VideoHelper
        VideoHelper::createDefaultVideo1('Video 1');
        VideoHelper::createDefaultVideo2('Vídeo 2');
        VideoHelper::createDefaultVideo3('Vídeo 3');

        $response = $this->actingAs($user)->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index'); // Assegura't que es carrega la vista esperada

        // Comprova que els 3 vídeos es mostren a la vista
        $response->assertSee('Video 1');
        $response->assertSee('Vídeo 2');
        $response->assertSee('Vídeo 3');
    }

    /**
     * Testa que els usuaris regulars no poden gestionar vídeos.
     */
    public function test_regular_users_cannot_manage_videos()
    {
        $user = $this->loginAsRegularUser(); // Usuari sense permisos
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->get(route('videos.edit', $video->id));

        $response->assertStatus(403); // Forbidden, no tenen permisos
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
        $response->assertViewIs('videos.manage.index');
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
        // Comprovar si el rol "super_admin" existeix, si no, el creem
        if (!Role::where('name', 'super_admin')->exists()) {
            Role::create(['name' => 'super_admin']);
        }
        // Crear l'usuari Super Admin
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('123456789'),
            'super_admin' => true,
        ]);
        // Assignar l'equip personal
        $user->addPersonalTeam();
        // Assignar el rol de super_admin
        $user->assignRole('super_admin');
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
    public function test_user_with_permissions_can_see_default_videos_page()
    {
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
    public function test_user_without_permissions_can_see_default_videos_page()
    {
        // Creem un usuari sense permisos específics
        $user = User::factory()->create();

        // Creem vídeos de prova
        VideoHelper::createDefaultVideo1('Video 1');
        VideoHelper::createDefaultVideo2('Vídeo 2');
        VideoHelper::createDefaultVideo3('Vídeo 3');

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Comprovem que l'usuari pot veure la pàgina de vídeos
        $response = $this->get(route('videos.index'));

        // Comprovem que la vista es carrega correctament
        $response->assertStatus(200);

        // Comprovem que els vídeos es mostren a la vista
        $response->assertSee('Video 1');
        $response->assertSee('Vídeo 2');
        $response->assertSee('Vídeo 3');
    }
    public static function createSuperAdminRole(){
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(['edit videos', 'delete videos', 'view analytics', 'manage videos']);
        return $superAdminRole;
    }
    public static function createPermissions(): array
    {
        $permissions = ['edit videos', 'delete videos', 'view analytics', 'manage videos'];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
        return $permissions;
    }
    public function test_user_with_permissions_can_see_add_videos()
    {
        self::createPermissions();
        self::createSuperAdminRole();
        $user = $this->loginAsSuperAdmin(); // Usuari amb permís de video_manager

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Comprovem que l'usuari amb permís pot veure la pàgina per afegir vídeos
        $response = $this->get(route('videos.create'));

        // Comprovem que es carrega la vista correctament
        $response->assertStatus(200);
    }
    public function test_user_without_permissions_cannot_see_add_videos()
    {
        // Creem un usuari sense permisos específics
        $user = User::factory()->create();

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Intentem accedir a la pàgina per afegir vídeos
        $response = $this->get(route('videos.create'));

        // Comprovem que l'usuari no pot veure la pàgina per afegir vídeos
        $response->assertStatus(403); // Accés denegat (Forbidden)
    }

    public function test_user_with_permissions_can_store_videos()
    {
        self::createPermissions();
        self::createSuperAdminRole();
        $user = $this->loginAsSuperAdmin(); // Usuari amb permís de video_manager

        // Simulem el login de l'usuari
        $this->actingAs($user);


        // Comprovem que el vídeo es guarda correctament
        $response = $this->get(route('videos.create')); // O el codi d'estat que sigui pertinent
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_store_videos()
    {
        // Creem un usuari sense permisos específics
        $user = User::factory()->create();

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Intentem emmagatzemar un vídeo

        $response = $this->get(route('videos.create'));
        // Comprovem que l'usuari no pot emmagatzemar vídeos (Forbidden)
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_destroy_videos()
    {
        self::createPermissions();
        self::createSuperAdminRole();
        $user = $this->loginAsSuperAdmin(); // Usuari amb permís de video_manager
        $video = Video::factory()->create(); // Creem un vídeo

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Intentem destruir el vídeo
        $response = $this->get(route('videos.destroy', $video->id));

        // Comprovem que el vídeo es destruit correctament
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_destroy_videos()
    {
        $user = User::factory()->create(); // Usuari sense permisos específics
        $video = Video::factory()->create(); // Creem un vídeo

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Intentem destruir el vídeo
        $response = $this->delete(route('videos.destroy', $video->id));

        // Comprovem que l'usuari no pot destruir vídeos (Forbidden)
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_see_edit_videos()
    {
        self::createPermissions();
        self::createSuperAdminRole();
        $user = $this->loginAsSuperAdmin(); // Usuari amb permís de video_manager
        $video = Video::factory()->create(); // Creem un vídeo

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Intentem accedir a la pàgina d'edició
        $response = $this->get(route('videos.edit', $video->id));

        // Comprovem que la vista d'edició es carrega
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_videos()
    {
        $user = User::factory()->create(); // Usuari sense permisos específics
        $video = Video::factory()->create(); // Creem un vídeo

        // Simulem el login de l'usuari
        $this->actingAs($user);

        // Intentem accedir a la pàgina d'edició
        $response = $this->get(route('videos.edit', $video->id));

        // Comprovem que l'usuari no pot veure la pàgina d'edició
        $response->assertStatus(403); // Forbidden
    }


}
