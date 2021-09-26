<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    public function videos()
    {
        return $this->hasMany(CourseVideos::class,'course_id');
    }
}
