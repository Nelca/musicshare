<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Socialite;
use App\User;
use DB;

class SocialLoginController extends Controller
{
    //

    public function githubLogin()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $github_user = Socialite::driver('github')->user();
	$user = User::firstOrCreate([
	                   'email' => $github_user->email,
			   'name' => $github_user->nickname,
		       ]);

	Auth::login($user);
	if ( Auth::check() ) {
	    $user = Auth::user();
	    $user_id = $user->id;
	    $songs = $this->getMypageSongs($user_id);
            $follow_users = $this->getFollowUserIds($user_id);
            $follower_users = $this->getFollowerUserIds($user_id);
	    return view('mypage.index', [
	        'songs' => $songs,
	        'follow' => $follow_users,
	        'follower' => $follower_users,
	        'user' => $user,
	    ]);
	}

        return 'github login error. sometihg went wlong.';
    }

    public function twitterLogin()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function twitterCallback()
    {
        $twitter_user = Socialite::driver('twitter')->user();
        $user = User::firstOrCreate([
			   'name' => $twitter_user->nickname,
		       ]);

	Auth::login($user);




	if ( Auth::check() ) {
            return view('mypage.index');
	}

        return 'twitter login error. sometihg went wlong.';
    }

    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $google_user = Socialite::driver('google')->user();
        $user = User::firstOrCreate([
			   'name' => $google_user->nickname,
		       ]);

	Auth::login($user);
	if ( Auth::check() ) {
            return view('mypage.index');
	}

        return 'google login error. sometihg went wlong.';
    }

    public function getMypageSongs ($user_id)
    {
	$query = " SELECT s.id, s.name, s.url, s.song_key, 'song' as type, u.name as user_name, s.updated_at as updated_at ";
	$query .= " from songs as s ";
	$query .= " inner join playlists as p ON s.playlist_id = p.id ";
	$query .= " inner join users as u on u.id = p.user_id ";
	$query .= " where u.id IN (";
	$query .= " select u2.id FROM users as u2 ";
	$query .= " inner join follows as f on u2.id = f.follow_user_id ";
	$query .= " WHERE f.user_id = ?)";
	$query .= " UNION ALL ";
	$query .= " select fav.id, fav.name, fav.url, fav.song_key, 'favorite' as type, u3.name as user_name, fav.updated_at as updated_at ";
	$query .= " from favorites as fav ";
	$query .= " inner join users as u3 on u3.id = fav.user_id";
	$query .= " where u3.id IN (";
	$query .= " select u4.id FROM users as u4";
	$query .= " inner join follows as f2 on u4.id = f2.follow_user_id ";
	$query .= " WHERE f2.user_id = ?)";
	$query .= " UNION ALL ";
	$query .= " SELECT s.id, s.name, s.url, s.song_key, 'follow' as type, u5.name as user_name, e.updated_at as updated_at ";
	$query .= " FROM evaluates as e";
	$query .= " JOIN songs as s ON s.id = e.evaluatable_id";
	$query .= " JOIN users as u5 ON e.user_id = u5.id";
	$query .= " WHERE e.user_id IN (select u4.id FROM users as u4";
	$query .= " inner join follows as f2 on u4.id = f2.follow_user_id ";
	$query .= " WHERE f2.user_id = ?)";
	$query .= " ORDER BY updated_at DESC";

	$songs = DB::select($query, [$user_id, $user_id, $user_id]);
	return $songs;
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

