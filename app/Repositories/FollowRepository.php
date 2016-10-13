<?php

namespace App\Repositories;

use App\User;
use App\Follow;

class FollowRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUnfollow(User $user, $follow_user_id)
    {
        return Follow::where('user_id', $user->id)
                    ->where('follow_user_id',$follow_user_id)
                    ->get()->first();
    }
}
