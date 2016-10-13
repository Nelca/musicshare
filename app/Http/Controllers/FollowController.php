<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Follow;
use App\User;
use App\Repositories\FollowRepository;

class FollowController extends Controller
{
    public function __construct(FollowRepository $follows)
    {
        $this->middleware('auth');
        $this->follows = $follows;
    }

     public function follow(Request $request)
    {
        $follow = new Follow;
        $user_id = $request->user()->id;
        $follow_user_id = $request->follow_user_id;
        $follow->user_id = $user_id;
        $follow->follow_user_id = $follow_user_id;
        $follow->save();
        return redirect('user/' . $follow_user_id);
    }
   //
    public function unfollow(Request $request)
    {
        $follow_user_id = $request->follow_user_id;
        $follow = $this->follows->forUnfollow($request->user(), $follow_user_id);
        $follow->delete();
        return redirect('user/' . $follow_user_id);
    }
}
