<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    //
    protected $fillable = array('evaluate');

    public function evaluatable()
    {
        return $this->morphTo();
    }
}
