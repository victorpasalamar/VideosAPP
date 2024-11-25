<?php

namespace App\Helpers;

use App\Models\User;

class UserHelper
{
    public static function createDefaultUser()
    {
        $credentials = config('users.default_user');
        return User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);
    }
}
