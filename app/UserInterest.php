<?php

namespace App;
use App\Interest;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    public function intrest()
    {
        return $this->belongsTo(Interest::class,'id');
    }

    public function getIntrestDataAttribute()
    {
        return $this->intrest;
    }
}
