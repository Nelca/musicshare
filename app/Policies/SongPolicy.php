<?php

namespace App\Policies;

use App\Playlist;
use App\Task;
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

    public function destroy(Playlist $playlist, Song $song)
    {
        return $playlist->id === $song->playlist-id;
    }
}
