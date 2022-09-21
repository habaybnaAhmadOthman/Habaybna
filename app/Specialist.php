<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }

    public function courses()
    {
        $this->hasMany(CourseSpecialist::class,'user_id','specialist_id');
    }

    public function articles()
    {
        $this->hasMany(NewContent::class,'user_id','author_id');
    }

    public function scopeCanMakeCalls($query)
    {
        return $query->where('make_calls',true);
    }
    public function callsAppointments()
    {
        return $this->hasMany(CallsAppointments::class,'specialist_id','user_id');
    }

    public function availiableAppointments()
    {
        // $appointments = CallsAppointments::whereDoesntHave('callsStatus')->get();
        return $this->hasMany(CallsAppointments::class,'specialist_id','user_id')->where('appointment','>=',gmdate("Y-m-d\TH:i:s\Z", strtotime('+ 7 hours')))->doesntHave('callsStatus');

    }

    public function getPhoneAttribute()
    {
        return $this->user->phone ;
    }
}
