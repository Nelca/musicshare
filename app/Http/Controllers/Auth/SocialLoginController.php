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
        $user = User::where('email', $github_user->email)->first();

	Auth::login($user);
	if ( Auth::check() ) {
            return view('welcome');
	}

        return 'github login error. sometihg went wlong.' .  $user->email;
    }

    public function twitterLogin()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function twitterCallback()
    {
        $twitter_user = Socialite::driver('twitter')->user();
        $user = User::where('name', $twitter_user->nickname)->first();

	Auth::login($user);
	if ( Auth::check() ) {
            return view('welcome');
	}

        return 'twitter login error. sometihg went wlong.' .  $user->email;
    }
}
