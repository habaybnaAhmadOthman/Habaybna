<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function courses()
    {
        $this->hasMany(CourseSpecialist::class,'user_id','specialist_id');
    }

    public function articles()
    {
        $this->hasMany(NewContent::class,'user_id','author_id');
    }

    public function scopeCanMakeCalls($query)
    {
        return $query->where('make_calls',true);
    }
}
