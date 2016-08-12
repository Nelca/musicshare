<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    //
    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');
	$this->users = $users;
    }

    public function index(Request $request)
    {
        return view('users.index', [
	    'user' => $this->users->forUser($request->user),
	]);
    }

}
