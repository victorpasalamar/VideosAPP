<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Crear una nova instància de l'acció.
     */
    public function __construct(protected DeletesTeams $deletesTeams)
    {
    }

    /**
     * Eliminar l'usuari donat.
     */
    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {
            $this->deleteTeams($user);
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        });
    }

    /**
     * Eliminar els equips i les associacions d'equips adjuntades a l'usuari.
     */
    protected function deleteTeams(User $user): void
    {
        // Desacoblem els equips associats
        $user->teams()->detach();

        // Iterem sobre els equips que l'usuari posseïx i els eliminem
        $user->ownedTeams->each(function ($team) {
            if ($team instanceof Team) {
                $this->deletesTeams->delete($team);
            }
        });
    }
}
