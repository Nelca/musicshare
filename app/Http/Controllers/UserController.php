<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Repositories\UserRepository;
use App\Repositories\PlaylistRepository;

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
        return view('users.index', [
	    'user' => $user,
	    'playlists' => $user->playlists,
	    'favorites' => $user->favorites,
	]);
    }

    public function userList (Request $request)
    {
        return view('users.list', [
	    'users' => User::all(),
	]);

    }

}
