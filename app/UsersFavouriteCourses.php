<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersFavouriteCourses extends Model
{
    protected $fillable = ['user_id','course_id'];


}
