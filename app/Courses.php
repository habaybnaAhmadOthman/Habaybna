<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    public function videos()
    {
        return $this->hasMany(CourseVideos::class,'course_id');
    }

    public function quiz()
    {
        return $this->hasOne(Quize::class,'course_id');
    }

    public function courseCategories()
    {
        return $this->hasMany(CategoryCourse::class,'course_id','id');
    }

    public function getCategoryNameAttribute()
    {
        if(count($this->courseCategories) > 0){

            $courseCategories = [] ;

            foreach ($this->courseCategories as $one) {
                $courseCategories[] = [
                    'id'=>$one->category->id,
                    'title'=>$one->category->title,
                ];
            }
            return $courseCategories;
        }
    }
}
