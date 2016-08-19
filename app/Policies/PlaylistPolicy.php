<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Playlist;

class PlaylistPolicy
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

    public function destroy(User $user, Playlist $playlist)
    {
        return $user->id == $playlist->user_id;
    }

    public function like(User $user, Playlist $playlist)
    {
        $isLikable = true;
        $evaluates = $playlist->evaluates;
        foreach ($evaluates as $key => $evaluate) {
	    if ($user->id == $evaluate->user_id) {
	        $isLikable = false; 
	    }
        } 
        return $isLikable; 
    }
}
