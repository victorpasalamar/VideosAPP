<?php

namespace App\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserHelper
{
    public static function createProfessorUser()
    {
        if (!Role::where('name', 'super_admin')->exists()) {
            Role::create(['name' => 'super_admin']);
        }
        $professor = User::firstOrCreate(
            [
                'name' => 'Professor User',
                'password' => bcrypt('password'),
                'email' => 'professor@user.com',
                'super_admin' => true,
            ]
        );
        $professor->assignRole('super_admin');
        return $professor;
    }

    public static function createRegularUser()
    {
        // Creem un usuari regular amb les dades especificades
        $user = User::factory()->create([
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
        $user = User::factory()->create([
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

    public static function createRegularUserRole(){
        $regularUserRole = Role::firstOrCreate(['name' => 'regular_user']);
        $regularUserRole->givePermissionTo(['view analytics']);
        return $regularUserRole;
    }

    public static function createVideoManagerRole(){
        $videoManagerRole = Role::firstOrCreate(['name' => 'video_manager']);
        $videoManagerRole->givePermissionTo(['edit videos', 'delete videos']);
        return $videoManagerRole;
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


}
