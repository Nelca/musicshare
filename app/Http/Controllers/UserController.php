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
        $follow_users = $this->getFollowUserIds($user->id);
        $follower_users = $this->getFollowerUserIds($user->id);
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

    public function follow  (Request $request, User $user)
    {
        $follow_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.follow_user_id')
			    ->select('u.*')
			    ->where('f.user_id', '=' , $user->id)
			    ->get('u.id');
        return view('users.follow', [
	    'follows' => $follow_users,
	]);
    }

    public function follower  (Request $request, User $user)
    {
        $follow_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.user_id')
			    ->select('u.*')
			    ->where('f.follow_user_id', '=' , $user->id)
			    ->get('u.id');
        return view('users.follow', [
	    'follows' => $follow_users,
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

}
