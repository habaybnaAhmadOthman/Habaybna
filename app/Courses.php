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

    public function courseProvider()
    {
        return $this->hasMany(CourseSpecialist::class,'course_id','id');
    }

    public function getCourseProvidersAttribute()
    {
        if(count($this->courseProvider) > 0){

            $courseProviders = [] ;
            // dd('providers',$this->courseProvider);
            foreach ($this->courseProvider as $one) {
                $courseProviders[] = [
                    'user_id'=>$one->specialist->user_id,
                    'firstName'=>$one->specialist->firstName,
                    'avatar'=>$one->specialist->avatar,
                    'specialization'=>$one->specialist->specialization,
                ];
            }
            return $courseProviders;
        }
    }

    public function getCourseLengthAttribute()
    {
       if(count($this->videos) > 0){
        $time = [];
        foreach ($this->videos as $video) {

            array_push($time,$video->length);
        }
        $sum = 0 ;
        foreach ($time as $key) {
            $parts = explode(':', $key);
            $sum += (0 * 60 * 60) + ($parts[0] * 60) + $parts[1];
        }

        return gmdate("H:i", $sum );
       }
       return gmdate("H:i", 0 );

    }


}
