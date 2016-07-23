<?php

namespace App\Repositories;

use App\User;
use App\Favorite;

class FavoriteRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Favorite::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}
