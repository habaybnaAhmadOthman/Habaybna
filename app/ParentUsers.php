<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentUsers extends Model
{
    protected $fillable = ['avatar','lastName','status'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
