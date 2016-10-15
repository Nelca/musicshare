<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Evaluate;

class Favorite extends Model
{
    //
    protected $fillable = ['name', 'url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluates()
    {
        return $this->morphMany(Evaluate::class, 'evaluatable');
    }
}
