<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursespurchaseorders extends Model
{
    protected $table = 'courses_purchase_orders';

    public function course()
    {
        return $this->hasOne(Courses::class,'id','course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function courseVideos()
    {
        return $this->hasMany(CourseVideos::class,'course_id');
    }

    public function coupon()
    {
        return $this->hasOne(PromoCode::class,'id','coupon_id');
    }

    public function getCourseVideosProgressAttribute()
    {
        $data = [];
        foreach ($this->course->videos as $key) {
            if($this->course->videos->count() > 0){
                $data[] = [
                    'course_id'=>$key->course_id,
                    'video_id'=>$key->id,
                    'in_progress'=>$key->videoProgress ? 1 : 0,
                    'is_complete'=>$key->videoProgress ? $key->videoProgress->is_complete : 0,
                ];
            }
        }
        return $data;
    }
}
