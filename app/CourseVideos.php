<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseVideos extends Model
{
    public function videoProgress()
    {
        return $this->hasOne(UserCourseProgress::class,'video_id');
    }
}
