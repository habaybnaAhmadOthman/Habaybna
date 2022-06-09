<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersQuiz extends Model
{
    public function users()
    {
        return $this->hasMany(User::class,'user_id');
    }
}
