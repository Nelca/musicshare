<?php

namespace App\Repositories;

use App\User;
use App\Playlist;
use App\Song;

class SongRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @return Collection
     */
    public function forPlaylist(Playlist $playlist)
    {
        return Song::where('playlist_id', $playlist->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}
