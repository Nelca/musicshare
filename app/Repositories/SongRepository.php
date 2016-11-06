<?php

namespace App\Repositories;

use App\Playlist;
use App\Song;
use App\User;
use DB;

class SongRepository
{
    /**
     *
     * @return Collection
     */
    public function forPlaylist($playlist)
    {
        return Song::with('evaluates')
	            ->where('playlist_id', $playlist)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    public function forUser(User $user)
    {
        $user_id = $user->id;
        $query = "SELECT s.*, p.name as playlist_name ";
        $query .= " FROM songs as s";
        $query .= " JOIN playlists as p ON s.playlist_id = p.id";
        $query .= " WHERE p.user_id = ?";

        $songs = DB::select($query, [$user_id]);

        return $songs;
    }
}
