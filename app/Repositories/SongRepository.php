<?php

namespace App\Repositories;

use App\Playlist;
use App\Song;

class SongRepository
{
    /**
     *
     * @return Collection
     */
    public function forPlaylist($playlist)
    {
        return Song::where('playlist_id', $playlist)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}
