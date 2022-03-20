<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCourseProgress extends Model
{
    protected $fillable = ['course_id','video_id','in_progress','is_complete','order_id'];
}
