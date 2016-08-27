<?php

namespace App\Repositories;

use App\User;
use App\Playlist;

class PlaylistRepository
{
    /**
     * Get all of playlists.
     *
     * @return Collection
     */
    public function all()
    {
        return Playlist::orderBy('created_at', 'asc')
                    ->paginate(5);
    }

    /**
     * Get all of the playlists for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
        return Playlist::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->paginate(5);
    }

    public function currentPlaylist($id)
    {
        return Playlist::where('id', $id)->get();
    }
}
