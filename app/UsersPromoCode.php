<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPromoCode extends Model
{
    protected $table = 'users_promo_codes' ;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class,'course_id');
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class,'call_package_id','user_id');
    }

}
