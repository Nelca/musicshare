<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Song;

class Playlist extends Model
{
    //
    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
