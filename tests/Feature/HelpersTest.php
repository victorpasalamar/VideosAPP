<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_user_creation()
    {
        $user = User::factory()->create([
            'name' => 'Víctor User',
            'email' => 'Víctor@user.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'Víctor@user.com',
        ]);
        $this->assertTrue(password_verify('password', $user->password));
        dd($user->toArray());
    }
}
