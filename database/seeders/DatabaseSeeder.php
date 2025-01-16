<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
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
    }
}
