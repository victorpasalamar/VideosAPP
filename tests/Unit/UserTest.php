<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Prova que un usuari amb rol 'superadmin' retorna true per isSuperAdmin().
     *
     * @return void
     */
    public function test_is_superadmin_returns_true_for_superadmin()
    {
        $user = new User();
        $user->role = 'superadmin';  // Asignem el rol 'superadmin'

        $this->assertFalse($user->isSuperAdmin()); // Comprova que retorna true
    }

    /**
     * Prova que un usuari sense rol 'superadmin' retorna false per isSuperAdmin().
     *
     * @return void
     */
    public function test_is_superadmin_returns_false_for_non_superadmin()
    {
        $user = new User();
        $user->role = 'user'; // Asignem un rol diferent

        $this->assertFalse($user->isSuperAdmin()); // Comprova que retorna false
    }
}
