<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


/**
 * @property string|null $profile_photo_url
 * @property mixed $role
 */
class User extends Authenticatable
{
    use HasApiTokens;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return string|null
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo_path
            ? Storage::url($this->profile_photo_path)
            : null;
    }

    public static function testedBy(): string
    {
        return \Tests\Unit\HelpersTest::class; // Ruta del test unitari de User
    }
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin'; // Verifica que la propietat 'role' és exactament 'super_admin'
    }
    public function addPersonalTeam()
    {
        // Creem l'equip personal de l'usuari
        $team = \App\Models\Team::forceCreate([
            'user_id' => $this->id,
            'name' => $this->name . "'s Team",
            'personal_team' => true,
        ]);

        // Assignem l'equip a l'usuari
        $this->current_team_id = $team->id;
        $this->save();
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
