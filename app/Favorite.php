<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

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
