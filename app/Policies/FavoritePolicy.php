<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Favorite;

class FavoritePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, Favorite $favorite)
    {
        return $user->id === $favorite->user_id;
    }

    public function like(User $user, Favorite $favorite)
    {
        $isLikable = true;
        $evaluates = $favorite->evaluates;
        foreach ($evaluates as $key => $evaluate) {
	    if ($user->id == $evaluate->user_id) {
	        $isLikable = false; 
	    }
        } 
        return $isLikable; 
    }
}
