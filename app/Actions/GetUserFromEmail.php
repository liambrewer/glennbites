<?php

namespace App\Actions;

use App\Models\User;

class GetUserFromEmail
{
    public function handle(string $email): User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = new User();
            $user->email = $email;
            $user->save();
        }

        return $user;
    }
}
