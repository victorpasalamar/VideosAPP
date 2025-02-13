<?php

namespace App\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * @method static factory()
 */
class UserHelper
{
    public static function createDefaultUser()
    {
        $credentials = config('users.default_user');
        return User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);
    }
    public static function createProfessorUser()
    {
        return User::firstOrCreate(
            ['email' => 'professor@user.com'],
            [
                'name' => 'Professor User',
                'password' => bcrypt('password'),
            ]
        );
    }

    public static function createRegularUser()
    {
        // Creem un usuari regular amb les dades especificades
        $user = self::factory()->create([
            'name' => 'Regular User',
            'email' => 'regular@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);

        // Afegim l'equip personal amb la funció que vam crear abans
        $user->addPersonalTeam();

        return $user;
    }

    public static function createVideoManagerUser()
    {
        // Assegurar-nos que el rol "video_manager" existeix
        if (!Role::where('name', 'video_manager')->exists()) {
            Role::create(['name' => 'video_manager']);
        }

        // Crear l'usuari
        $user = self::factory()->create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);

        // Assignar equip personal
        $user->addPersonalTeam();

        // Assignar rol
        $user->assignRole('video_manager');

        return $user;
    }

    public static function createSuperAdminUser()
    {
        // Comprovar si el rol "super_admin" existeix, si no, el creem
        if (!Role::where('name', 'super_admin')->exists()) {
            Role::create(['name' => 'super_admin']);
        }

        // Crear l'usuari Super Admin
        $user = self::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);

        // Assignar l'equip personal
        $user->addPersonalTeam();

        // Assignar el rol de super_admin
        $user->assignRole('super_admin');

        return $user;
    }

}
