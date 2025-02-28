<?php

namespace Tests\Unit;

use App\Helpers\UserHelper;
use App\Helpers\VideoHelper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_user_creation()
    {
// Crear l'usuari
        $user = User::factory()->create([
            'name' => 'Víctor User',
            'email' => 'Víctor@user.com',
            'password' => bcrypt('password'),
        ]);

        // Crear l'equip personal per a l'usuari (lògica de createTeam() aquí)
        $team = \App\Models\Team::forceCreate([
            'user_id' => $user->id,
            'name' => $user->name."'s Team",  // Canviat aquí
            'personal_team' => true,
        ]);

        // Assignar l'equip a l'usuari
        $user->current_team_id = $team->id;
        $user->save();

        // Comprovar que l'usuari existeix a la base de dades
        $this->assertDatabaseHas('users', [
            'email' => 'Víctor@user.com',
        ]);

        // Comprovar que la contrasenya és correcta
        $this->assertTrue(password_verify('password', $user->password));

        // Comprovar que l'equip personal s'ha creat
            $this->assertDatabaseHas('teams', [
            'user_id' => $user->id,
            'name' => "Víctor User's Team",  // Canviat aquí
        ]);

        //dd($user->toArray());
    }
    public function test_default_profe_creation()
    {
        $professor = UserHelper::createProfessorUser();

        // Fem servir la nova funció per afegir el personal team
        $professor->addPersonalTeam();

        // Verifiquem que l'usuari és a la base de dades
        $this->assertDatabaseHas('users', [
            'email' => 'professor@user.com',
        ]);

        // Comprovem que la contrasenya és correcta
        $this->assertTrue(password_verify('password', $professor->password));

        // Comprovem que l'equip personal s'ha creat correctament
        $this->assertDatabaseHas('teams', [
            'user_id' => $professor->id,
            'name' => "Professor User's Team",
        ]);

        // Verifiquem que la funció isSuperAdmin() funciona
        $this->assertFalse($professor->isSuperAdmin());
    }
    public function test_create_default_video()
    {
        $video = VideoHelper::createDefaultVideo();

        $this->assertDatabaseHas('videos', [
            'title' => 'Vídeo per defecte',
        ]);
        $this->assertNotNull($video->published_at);
        //dd($video->toArray());
    }
    public function test_regular_user_creation()
    {
        {
            $user = User::createRegularUser();

            // Comprovem que l'usuari s'ha creat correctament
            $this->assertDatabaseHas('users', [
                'email' => 'regular@videosapp.com',
            ]);

            // Comprovem que la contrasenya és correcta
            $this->assertTrue(password_verify('123456789', $user->password));

            // Comprovem que té un equip assignat
            $this->assertDatabaseHas('teams', [
                'user_id' => $user->id,
                'name' => "Regular User's Team",
            ]);
        }
    }

    public function test_video_manager_user_creation()
    {
        $user = User::createVideoManagerUser();

        // Comprovem que l'usuari s'ha creat correctament
        $this->assertDatabaseHas('users', [
            'email' => 'videosmanager@videosapp.com',
        ]);

        // Comprovem que la contrasenya és correcta
        $this->assertTrue(password_verify('123456789', $user->password));

        // Comprovem que té un equip assignat
        $this->assertDatabaseHas('teams', [
            'user_id' => $user->id,
            'name' => "Video Manager's Team",
        ]);

        // Comprovem que té assignat el rol de "video_manager"
        $this->assertTrue($user->hasRole('video_manager'));
    }

    public function test_super_admin_creation()
    {
        $user = User::createSuperAdminUser();

        // Comprovem que l'usuari s'ha creat correctament
        $this->assertDatabaseHas('users', [
            'email' => 'superadmin@videosapp.com',
        ]);

        // Comprovem que la contrasenya és correcta
        $this->assertTrue(password_verify('123456789', $user->password));

        // Comprovem que té un equip assignat
        $this->assertDatabaseHas('teams', [
            'user_id' => $user->id,
            'name' => "Super Admin's Team",
        ]);

        // Comprovem que té assignat el rol de "super_admin"
        $this->assertTrue($user->hasRole('super_admin'));
    }
}
