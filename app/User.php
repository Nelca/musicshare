<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Favorite;
use App\Playlist;
use App\Follow;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function follow()
    {
        return $this->hasManyThrough(User::class, Follow::class, 'user_id', 'follow_user_id');
    }

    public function follower()
    {
        return $this->hasManyThrough(User::class, Follow::class, 'follow_user_id', 'user_id');
    }
}
