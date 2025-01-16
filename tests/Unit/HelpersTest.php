<?php

namespace Tests\Unit;

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

        dd($user->toArray());
    }
    public function test_default_profe_creation()
    {
        $professor = User::factory()->create([
            'name' => 'Professor User',
            'email' => 'professor@professor.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'professor@professor.com',
        ]);
        // Crear l'equip personal per a l'usuari (lògica de createTeam() aquí)
        $team = \App\Models\Team::forceCreate([
            'user_id' => $professor->id,
            'name' => $professor->name."'s Team",  // Canviat aquí
            'personal_team' => true,
        ]);

        // Assignar l'equip a l'usuari
        $professor->current_team_id = $team->id;
        $professor->save();

        // Comprovar que l'usuari existeix a la base de dades
        $this->assertDatabaseHas('users', [
            'email' => 'professor@professor.com',
        ]);

        // Comprovar que la contrasenya és correcta
        $this->assertTrue(password_verify('password', $professor->password));

        // Comprovar que l'equip personal s'ha creat
        $this->assertDatabaseHas('teams', [
            'user_id' => $professor->id,
            'name' => "Professor User's Team",  // Canviat aquí
        ]);
        $this->assertTrue(password_verify('password', $professor->password));
        dd($professor->toArray());
    }
    public function test_create_default_video()
    {
        $video = VideoHelper::createDefaultVideo();

        $this->assertDatabaseHas('videos', [
            'title' => 'Vídeo per defecte',
        ]);
        $this->assertNotNull($video->published_at);
        dd($video->toArray());
    }
}
