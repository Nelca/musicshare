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

	$query = " select * from songs as s inner join playlists as p ON s.playlist_id = p.id inner join users as u on u.id = p.user_id where u.id IN (select u2.id FROM users as u2 inner join follows as f on u2.id = f.follow_user_id WHERE f.user_id = ?)";

	$songs = DB::select($query, [$user_id]);
        return view('mypage.index', [
	    'songs' => $songs,
	]);
    }
}
