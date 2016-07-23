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
}
