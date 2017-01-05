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

    public function setSongKey($url)
    {
        $song_key = "";
        // urlからkey取得
        $url_query_str = parse_url($url, PHP_URL_QUERY);
        parse_str($url_query_str, $url_querys);
        if (isset($url_querys['v'])) {
            $song_key = $url_querys['v'];
        }

        return $song_key;
    }

    public function rateVideo($user, $song, $rate)
    {
        $token = $user->oauth_token;
        $base_url = "https://www.googleapis.com/youtube/v3/videos/rate?";
        $base_url .= "rating=" . $rate;
        $base_url .= "&id=" . $song->song_key;
        $base_url .= "&access_token=" . $token;
        $query = array();
        $query = http_build_query($query, "", "&");
        $header = array(
            'Content-Type: application/x-www-form-urlencoded',
            "Content-Length: ".strlen($query)
        );
        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => implode("\r\n", $header),
                'content' => $query
            )
        );
        $context = stream_context_create($context);
        $response = file_get_contents($base_url, false, $context);
        return $response;
    }

}
