<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCourseProgress extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_course_progress' ;
    protected $fillable = ['course_id','video_id','in_progress','is_complete','order_id'];
}
