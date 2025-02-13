<?php

namespace Database\Seeders;

use App\Helpers\UserHelper;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        UserHelper::createDefaultUser();
        // Crear un usuari per defecte
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Mai posis contrasenyes en text pla en producció
        ]);

        // Crear diversos vídeos per defecte
        Video::factory()->create([
            'title' => 'Vídeo per defecte',
            'description' => 'Descripció per defecte del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'published_at' => now(),
        ]);

        $this->command->info('Usuaris i vídeos per defecte creats.');

        // Assegurar que els permisos existeixen
        $permissions = ['edit videos', 'delete videos', 'view analytics'];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Assegurar que el rol "super_admin" tingui tots els permisos
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());


        // Assegurar que els permisos existeixen
        $permissions = ['edit videos', 'delete videos', 'view analytics'];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Rol Video Manager
        $videoManagerRole = Role::firstOrCreate(['name' => 'video_manager']);
        $videoManagerRole->givePermissionTo(['edit videos', 'delete videos']);

        // Rol Regular User
        $regularUserRole = Role::firstOrCreate(['name' => 'regular_user']);
        $regularUserRole->givePermissionTo(['view analytics']); // O assignar permisos específics que vulguis per al regular user

        // Crear els usuaris per defecte
        // Usuari Regular
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'regular@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);
        $regularUser->assignRole('regular_user'); // Assignar rol regular_user
        $regularUser->addPersonalTeam(); // Afegir l'equip personal

        // Usuari Video Manager
        $videoManagerUser = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);
        $videoManagerUser->assignRole('video_manager'); // Assignar rol video_manager
        $videoManagerUser->addPersonalTeam(); // Afegir l'equip personal

        // Usuari Super Admin
        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);
        $superAdminUser->assignRole('super_admin'); // Assignar rol super_admin
        $superAdminUser->addPersonalTeam(); // Afegir l'equip personal

    }
}
