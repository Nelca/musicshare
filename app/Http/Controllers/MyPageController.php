<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\User;
use Illuminate\Http\Response;

class MyPageController extends Controller
{
 
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
	$user = User::find($user_id);

        $follow_users = $this->getFollowUserIds($user_id);
        $follower_users = $this->getFollowerUserIds($user_id);
	$songs = $this->getSongs($user_id);

        $url = "https://www.googleapis.com/youtube/v3/activities?part=snippet,contentDetails&mine=true&access_token=" . $user->oauth_token;
	$json = file_get_contents($url);
	$jsonResponse = json_decode($json);
	$youtube_activity_list = $jsonResponse->items;

        return view('mypage.index', [
	    'songs' => $songs,
	    'follow' => $follow_users,
	    'follower' => $follower_users,
	    'user' => $user,
	    'youtube_datas' => $youtube_activity_list,
	]);
    }

    public function likes (Request $request)
    {
        $user_id = $request->user()->id;
	$query = "SELECT s.* ";
	$query .= " FROM evaluates as e";
	$query .= " JOIN songs as s ON s.id = e.evaluatable_id";
	$query .= " WHERE e.user_id = ?";
	$query .= " AND e.evaluatable_type = ?";

	$songs = DB::select($query, [$user_id, "songs"]);

	$p_query = "SELECT p.* ";
	$p_query .= " FROM evaluates as e";
	$p_query .= " JOIN playlists as p ON p.id = e.evaluatable_id";
	$p_query .= " WHERE e.user_id = ?";
	$p_query .= " AND e.evaluatable_type = ?";

	$playlists = DB::select($p_query, [$user_id, "playlists"]);

        return view('mypage.likes', [
	    'songs' => $songs,
	    'playlists' => $playlists,
	]);
    }

    public function getFollowUserIds ($user_id)
    {
        $follow_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.follow_user_id')
			    ->where('f.user_id', '=' , $user_id)
			    ->lists('u.id');
        return $follow_users;
    }

    public function getFollowerUserIds ($user_id)
    {
        $follower_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.user_id')
			    ->where('f.follow_user_id', '=' , $user_id)
			    ->lists('u.id');
        return $follower_users;
    }

    public function getSongs ($user_id)
    {
	$query = " SELECT s.id, s.name, s.url, s.song_key, 'song' as type, u.name as user_name, s.updated_at as updated_at ";
	$query .= " from songs as s ";
	$query .= " inner join playlists as p ON s.playlist_id = p.id ";
	$query .= " inner join users as u on u.id = p.user_id ";
	$query .= " where u.id IN (";
	$query .= " select u2.id FROM users as u2 ";
	$query .= " inner join follows as f on u2.id = f.follow_user_id ";
	$query .= " WHERE f.user_id = ?)";
	$query .= " UNION ALL ";
	$query .= " select fav.id, fav.name, fav.url, fav.song_key, 'favorite' as type, u3.name as user_name, fav.updated_at as updated_at ";
	$query .= " from favorites as fav ";
	$query .= " inner join users as u3 on u3.id = fav.user_id";
	$query .= " where u3.id IN (";
	$query .= " select u4.id FROM users as u4";
	$query .= " inner join follows as f2 on u4.id = f2.follow_user_id ";
	$query .= " WHERE f2.user_id = ?)";
	$query .= " UNION ALL ";
	$query .= " SELECT s.id, s.name, s.url, s.song_key, 'follow' as type, u5.name as user_name, e.updated_at as updated_at ";
	$query .= " FROM evaluates as e";
	$query .= " JOIN songs as s ON s.id = e.evaluatable_id";
	$query .= " JOIN users as u5 ON e.user_id = u5.id";
	$query .= " WHERE e.user_id IN (select u4.id FROM users as u4";
	$query .= " inner join follows as f2 on u4.id = f2.follow_user_id ";
	$query .= " WHERE f2.user_id = ?)";
	$query .= " ORDER BY updated_at DESC";

	$songs = DB::select($query, [$user_id, $user_id, $user_id]);

	return $songs;
    }

}
