<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class MyPageController extends Controller
{
 
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

	$query = " select s.id, s.name, s.url, s.song_key, 'song' as type from songs as s ";
	$query .= "inner join playlists as p ON s.playlist_id = p.id ";
	$query .= "inner join users as u on u.id = p.user_id ";
	$query .= "where u.id IN (";
	$query .= "select u2.id FROM users as u2 ";
	$query .= "inner join follows as f on u2.id = f.follow_user_id ";
	$query .= " WHERE f.user_id = ?)";
	$query .= "UNION ALL";
	$query .= " select fav.id, fav.name, fav.url, fav.song_key, 'favorite' as type from favorites as fav ";
	$query .= " inner join users as u3 on u3.id = fav.user_id";
	$query .= " where u3.id IN (";
	$query .= " select u4.id FROM users as u4";
	$query .= " inner join follows as f2 on u4.id = f2.follow_user_id ";
	$query .= " WHERE f2.user_id = ?)";

	$songs = DB::select($query, [$user_id, $user_id]);
        return view('mypage.index', [
	    'songs' => $songs,
	]);
    }
}
