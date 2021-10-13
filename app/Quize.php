<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quize extends Model
{
    protected $fillable = ['title','status','course_id'];

    public function questions()
    {
        return $this->hasMany(Question::class,'quiz_id');
    }
}
