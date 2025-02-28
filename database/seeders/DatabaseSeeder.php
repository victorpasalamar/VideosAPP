<?php

namespace Database\Seeders;

use App\Helpers\UserHelper;
use App\Helpers\VideoHelper;
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
        // Crear diversos vídeos per defecte
        VideoHelper::createDefaultVideo1('Video 1');
        VideoHelper::createDefaultVideo2('Vídeo 2');
        VideoHelper::createDefaultVideo3('Vídeo 3');
        VideoHelper::createDefaultVideo4('Vídeo 4');
        VideoHelper::createDefaultVideo5('Vídeo 5');

        // Assegurar que els permisos existeixen
        UserHelper::createPermissions();

        // Assegurar que el rol "super_admin" tingui tots els permisos
       UserHelper::createSuperAdminRole();

        // Rol Video Manager
        UserHelper::createVideoManagerRole();

        // Rol Regular User
        UserHelper::createRegularUserRole();

        // Usuari Regular (sense permisos especials)
        UserHelper::createRegularUser();

        // Usuari Video Manager
        UserHelper::createVideoManagerUser();

        // Usuari Super Admin
        UserHelper::createSuperAdminUser();

    }
}
