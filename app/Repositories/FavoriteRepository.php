<?php

namespace App\Repositories;

use App\User;
use App\Favorite;

class FavoriteRepository
{
    public function forUser(User $user)
    {
        return Favorite::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}
