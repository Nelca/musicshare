<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser($user_id)
    {
        $users = User::where('id', $user_id)->get();
        return $users[0];
    }
}
