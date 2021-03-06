<?php

namespace App\Repositories;

use App\User;
use App\Favorite;
use DB;

class MypageRepository
{

    public function getFollowUserIds($user_id)
    {
        $follow_users = DB::table('users as u')
            ->join('follows as f', 'u.id', '=', 'f.follow_user_id')
            ->where('f.user_id', '=' , $user_id)
            ->lists('u.id');
        return $follow_users;
    }

    public function getFollowerUserIds($user_id)
    {
        $follower_users = DB::table('users as u')
            ->join('follows as f', 'u.id', '=', 'f.user_id')
            ->where('f.follow_user_id', '=' , $user_id)
            ->lists('u.id');
        return $follower_users;
    }

    public function getYoutubeLikeSongs($user)
    {
        $youtube_activity_list = array();
        $youtube_list = array();
        $url = "https://www.googleapis.com/youtube/v3/activities?part=snippet,contentDetails&mine=true&maxResults=10&access_token=" . $user->oauth_token;

        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true)
        ));

        $json = file_get_contents($url, false, $context);
        $jsonResponse = json_decode($json, true);
        if (isset($jsonResponse["items"])) {
            $youtube_activity_list = $jsonResponse["items"];
        }

        // likeのみ
        foreach ($youtube_activity_list as $key => $y_activiity) {
            if ($y_activiity["snippet"]["type"] != 'like') {
                unset($youtube_activity_list[$key]);
            } else {
                $y_activitys = new \stdClass();
                $y_activitys->id = $y_activiity["id"];
                $y_activitys->name = $y_activiity["snippet"]["title"];
                $y_activitys->url = "https://www.youtube.com/watch?v=" . $y_activiity["contentDetails"]["like"]["resourceId"]["videoId"];
                $y_activitys->song_key = $y_activiity["contentDetails"]["like"]["resourceId"]["videoId"];
                $y_activitys->type = "youtube_acivity";
                $y_activitys->user_name = $user->name;
                array_push($youtube_list, $y_activitys);
            }
        }
        return $youtube_list;
    }

    public function getLikedSongs($user_id)
    {
        $query = "SELECT s.* ";
        $query .= " FROM evaluates as e";
        $query .= " JOIN songs as s ON s.id = e.evaluatable_id";
        $query .= " WHERE e.user_id = ?";
        $query .= " AND e.evaluatable_type = ?";

        $songs = DB::select($query, [$user_id, "songs"]);

        return $songs;
    }

    public function getLikedPlaylists($user_id)
    {
        $p_query = "SELECT p.*, u.id as user_id, u.name as user_name ";
        $p_query .= " FROM evaluates as e";
        $p_query .= " JOIN playlists as p ON p.id = e.evaluatable_id";
        $p_query .= " JOIN users as u ON p.user_id = u.id";
        $p_query .= " WHERE e.user_id = ?";
        $p_query .= " AND e.evaluatable_type = ?";

        $playlists = DB::select($p_query, [$user_id, "playlists"]);

        return $playlists;

    }

    public function getSongs($user)
    {
        $user_id = $user->id;
        $query = " SELECT s.id, s.name, s.url, s.song_key, 'song' as type, u.name as user_name, s.updated_at as updated_at, p.id as playlist_id, p.name as playlist_name ";
        $query .= " from songs as s ";
        $query .= " inner join playlists as p ON s.playlist_id = p.id ";
        $query .= " inner join users as u on u.id = p.user_id ";
        $query .= " where u.id IN (";
        $query .= " select u2.id FROM users as u2 ";
        $query .= " inner join follows as f on u2.id = f.follow_user_id ";
        $query .= " WHERE f.user_id = ?)";
        $query .= " UNION ALL ";
        $query .= " select fav.id, fav.name, fav.url, fav.song_key, 'favorite' as type, u3.name as user_name, fav.updated_at as updated_at, 0 as playlist_id, '' as  playlist_name";
        $query .= " from favorites as fav ";
        $query .= " inner join users as u3 on u3.id = fav.user_id";
        $query .= " where u3.id IN (";
        $query .= " select u4.id FROM users as u4";
        $query .= " inner join follows as f2 on u4.id = f2.follow_user_id ";
        $query .= " WHERE f2.user_id = ?)";
        $query .= " UNION ALL ";
        $query .= " SELECT s.id, s.name, s.url, s.song_key, 'follow' as type, u5.name as user_name, e.updated_at as updated_at , 0 as playlist_id , '' as  playlist_name";
        $query .= " FROM evaluates as e";
        $query .= " JOIN songs as s ON s.id = e.evaluatable_id";
        $query .= " JOIN users as u5 ON e.user_id = u5.id";
        $query .= " WHERE e.user_id IN (select u4.id FROM users as u4";
        $query .= " inner join follows as f2 on u4.id = f2.follow_user_id ";
        $query .= " WHERE f2.user_id = ?)";
        $query .= " ORDER BY updated_at DESC";

        $songs = DB::select($query, [$user_id, $user_id, $user_id]);

        $youtube_list = array();
        if ($user->oauth_token) {
            $youtube_list = $this->getYoutubeLikeSongs($user);
        }
        
        $songs = array_merge($songs, $youtube_list);

        return $songs;
    }

}
