<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Repositories\UserRepository;
use App\Repositories\PlaylistRepository;
use DB;
use Auth;

class UserController extends Controller
{
    //
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index(Request $request, User $user)
    {
        $follow_users = $this->users->getFollowUserIds($user->id);
        $follower_users = $this->users->getFollowerUserIds($user->id);
        $youtube_activity_list = array();
        $login_user = Auth::user();
        if ($login_user && $login_user->oauth_token && $user->channel_id) {
            // ToDo modify view
            //$youtube_activity_list = $this->users->getYoutubeActivity($user, $login_user);
        }

        return view('users.index', [
                'user' => $user,
                'playlists' => $user->playlists,
                'favorites' => $user->favorites,
                'follow' => $follow_users,
                'follower' => $follower_users,
                'youtube_datas' => $youtube_activity_list,
            ]);
    }

    public function userList (Request $request)
    {
        $users = $this->users->getAllUsers();

        return view('users.list', [
            'users' => $users,
        ]);

    }

    public function follow  (Request $request, User $user)
    {
        $follow_users =  $this->users->getFollow($user->id);

        return view('users.follow', [
            'follows' => $follow_users,
            'is_follow' => true,
        ]);
    }

    public function follower  (Request $request, User $user)
    {
        $follower_users =  $this->users->getFollower($user->id);

        return view('users.follow', [
            'follows' => $follower_users,
            'is_follow' => false,
        ]);
    }

}
