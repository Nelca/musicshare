<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Favorite;
use App\Playlist;
use App\Follow;
use App\Song;

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

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
