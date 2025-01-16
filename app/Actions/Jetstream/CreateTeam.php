<?php
namespace App\Actions\Jetstream;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;
class CreateTeam implements CreatesTeams
{
    /**
     * Valida i crea un nou equip per a l'usuari donat.
     * @param  User  $user
     * @param  array<string, string>  $input
     * @return Team
     */
    public function create(User $user, array $input): Team
    {
        // Autoritzem a l'usuari per crear un equip
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());
        // Validem la creació de l'equip
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createTeam');
        // Disparam l'esdeveniment per afegir l'equip
        AddingTeam::dispatch($user);

        // Creem l'equip associat a l'usuari
        /** @var Team $team */
        $team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'personal_team' => false,
        ]);

        // Finalment, retornem l'equip creat (és de tipus Team, no de tipus Model)
        return $team;
    }
}
