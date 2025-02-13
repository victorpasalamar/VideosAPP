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
        return $this->role === 'superadmin'; // Verifica que la propietat 'role' és exactament 'superadmin'
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



}
