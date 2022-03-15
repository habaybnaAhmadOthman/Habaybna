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
}
