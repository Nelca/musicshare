<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class MypagePolicy
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

    public function like(User $user, Song $song)
    {
        $isLikable = true;
        $evaluates = $song->evaluates;
        foreach ($evaluates as $key => $evaluate) {
	    if ($user->id == $evaluate->user_id) {
	        $isLikable = false; 
	    }
        } 
        return $isLikable; 
    }
}
