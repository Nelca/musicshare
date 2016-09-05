<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Follow;
use App\User;

class FollowController extends Controller
{
    //
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
}
