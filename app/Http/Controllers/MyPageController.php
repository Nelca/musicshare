<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Repositories\MypageRepository;
use App\User;
use DB;
use Auth;

class MyPageController extends Controller
{
    public function __construct(MypageRepository $mypageRepo)
    {
        $this->mypageRepo = $mypageRepo;
    }

    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $user = User::find($user_id);

        $follow_users = $this->mypageRepo->getFollowUserIds($user_id);
        $follower_users = $this->mypageRepo->getFollowerUserIds($user_id);
        $songs = $this->mypageRepo->getSongs($user);

        $youtube_activity_list = array();
        if ($user->oauth_token) {
            $youtube_activity_list = $this->mypageRepo->getYoutubeLikeSongs($user);
        }
        return view('mypage.index', [
                    'songs' => $songs,
                    'follow' => $follow_users,
                    'follower' => $follower_users,
                    'user' => $user,
                    'youtube_datas' => $youtube_activity_list,
                ]);
    }

    public function likes (Request $request)
    {
        $user = $request->user();
        $user_id = $user->id;
        $songs = $this->mypageRepo->getLikedSongs($user_id);
        $playlists = $this->mypageRepo->getLikedPlaylists($user_id);

        return view('mypage.likes', [
                'songs' => $songs,
                'playlists' => $playlists,
                ]);
    }

    public function editView()
    {
        $user = Auth::user();
        return view('mypage.edit', [
                    'user' => $user,
                    'isUpdate' => false,
                ]);
    }

    public function editUpdate(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return view('mypage.edit', [
                    'user' => $user,
                    'isUpdate' => true,
                ]);
    }

}
