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

    public function index(Request $request)
    {
        $user = $this->users->forUser($request->user);
        return view('users.index', [
	    'user' => $user,
	    'playlists' => $this->playlists->forUser($user),
	]);
    }

}
