<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Socialite;
use App\User;

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
            return view('welcome');
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
            return view('welcome');
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
            return view('welcome');
	}

        return 'google login error. sometihg went wlong.';
    }
}
