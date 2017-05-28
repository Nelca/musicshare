<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Playlist;
use App\Evaluate;

class Song extends Model
{
    protected $fillable = ['name'];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    public function evaluates()
    {
        return $this->morphMany(Evaluate::class, 'evaluatable');
    }
}
