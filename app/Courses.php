<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


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
                    'lastName'=>$one->specialist->lastName,
                    'avatar'=>$one->specialist->avatar,
                    'specialization'=>$one->specialist->specialization,
                    'bio'=>$one->specialist->disorders_work_with,

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

            $sum +=  ($parts[0] * 60) + $parts[1];
        }
        // dd($sum);
        // $s = $sum%60;
        // $m = floor(($sum%3600)/60);
        // $h = floor(($sum%86400)/3600);

        // // $min =  gmdate("H:i:", $sum );
        // // dd($min);
        // if ($h < 1) {
        //     $h = "00";
        // }
        // if ($m < 1) {
        //     $m = "00";
        // }
        // $length = $h.':'.$m ;

        // dd($length);
       return $sum ;

       }
       return 0;

    }

    public function courseProgress()
    {
        return $this->hasMany(courseProgress::class,'course_id');
    }

    public function favouriteUsers()
    {
        return $this->belongsToMany('App\User','users_favourite_courses','course_id')->withPivot('course_id','user_id');


    }
    public function favouriteCourse()
    {
        return $this->hasMany(UsersFavouriteCourses::class,'course_id');

    }

    public function getIsUserLikeCourseAttribute()
    {
        if($this->favouriteCourse->count() > 0)
            {
                $isLiked = false ;
                foreach ($this->favouriteCourse as $key ) {
                    if($key->user_id == Auth::id()){

                        $isLiked = true ;
                    }
                }
                return $isLiked ;
            }
    }

    public function certificateLogos()
    {
        return $this->hasMany(CertificateLogos::class,'course_id');
    }
}
