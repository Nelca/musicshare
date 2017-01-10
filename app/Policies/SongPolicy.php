<?php

namespace App\Policies;

use App\User;
use App\Playlist;
use App\Song;
use Illuminate\Auth\Access\HandlesAuthorization;

class SongPolicy
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

    public function destroy(User $user, Song $song)
    {
        return $user->id === $song->user_id;
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
