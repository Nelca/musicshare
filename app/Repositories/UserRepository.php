<?php

namespace App\Repositories;

use App\User;
use DB;

class UserRepository
{
    public function getYoutubeActivity($user, $login_user)
    {
        $youtube_activity_list = array();
        $url = "https://www.googleapis.com/youtube/v3/activities?";
        $url .= "part=snippet,contentDetails";
        $url .= "&channelId=" . $user->channel_id;
        $url .= "&maxResults=10";
        $url .= "&access_token=" . $login_user->oauth_token;

        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true)
        ));
        $json = file_get_contents($url, false, $context);
        $jsonResponse = json_decode($json, true);
        if (isset($jsonResponse["items"])) {
            $youtube_activity_list = $jsonResponse["items"];
        }

        // likeのみ
        foreach ($youtube_activity_list as $key => $y_activiity) {
            if ($y_activiity["snippet"]["type"] != 'like') {
                unset($youtube_activity_list[$key]);
            }
        }

        return $youtube_activity_list;
    }

    public function getFollowUserIds($user_id)
    {
        $follow_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.follow_user_id')
                        ->where('f.user_id', '=' , $user_id)
                        ->lists('u.id');

        return $follow_users;
    }

    public function getFollowerUserIds($user_id)
    {
        $follower_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.user_id')
                        ->where('f.follow_user_id', '=' , $user_id)
                        ->lists('u.id');

        return $follower_users;
    }

    public function getFollow($user_id)
    {
        $follow_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.follow_user_id')
                        ->select('u.*')
                        ->where('f.user_id', '=' , $user_id)
                        ->get('u.id');

        return $follow_users;

    }

    public function getFollower($user_id)
    {
        $follower_users = DB::table('users as u')
	                    ->join('follows as f', 'u.id', '=', 'f.user_id')
                        ->select('u.*')
                        ->where('f.follow_user_id', '=' , $user_id)
                        ->get('u.id');

        return $follower_users;
    }

    public function getAllUsers()
    {
        $users = User::all();

        return $users;
    }
}
