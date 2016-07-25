<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Playlist;

class Song extends Model
{
    //

    protected $fillable = ['name'];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
