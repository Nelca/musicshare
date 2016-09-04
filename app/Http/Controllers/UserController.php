<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Repositories\UserRepository;
use App\Repositories\PlaylistRepository;
use DB;

class UserController extends Controller
{
    //
    public function __construct(UserRepository $users, PlaylistRepository $playlists)
    {
        $this->middleware('auth');
	$this->users = $users;
	$this->playlists = $playlists;
    }

    public function index(Request $request, User $user)
    {
        $follow_users = $this->getFollowUsers($user->id);
        $follower_users = $this->getFollowerUsers($user->id);
        return view('users.index', [
	    'user' => $user,
	    'playlists' => $user->playlists,
	    'favorites' => $user->favorites,
	    'follow' => $follow_users,
	    'follower' => $follower_users,
	]);
    }

    public function userList (Request $request)
    {
        return view('users.list', [
	    'users' => User::all(),
	]);

    }

    public function getFollowUsers ($user_id)
    {
        $follow_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.follow_user_id')
			    ->select('u.*')
			    ->where('f.user_id', '=' , $user_id)
			    ->get();
        return $follow_users;
    }

    public function getFollowerUsers ($user_id)
    {
        $follower_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.user_id')
			    ->select('u.*')
			    ->where('f.follow_user_id', '=' , $user_id)
			    ->get();
        return $follower_users;
    }

}
