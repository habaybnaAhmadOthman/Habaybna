<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Child extends Model
{
    use HasFactory;
    protected $guarded=[];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDobAttribute($value)
    {

        $years = Carbon::parse($value)->diff(Carbon::now())->format('%y');
        $months = Carbon::parse($value)->diff(Carbon::now())->format('%m');
        $age = "";
        if($years > 0 && $months > 0 ) {
            $age = $years." سنة ".$months." شهر ";
        }
        if($years > 0 && $months == 0 ) {
            $age = $years." سنة ";
        }
        if($years == 0 && $months > 0 ) {
            $age =$months." شهر ";
        }
        $data['dob'] = $value;
        $data['age'] = $age;
        return $data  ;
    }

    public function getInterestsAttribute($value)
    {
        return json_decode($value)  ;
    }

}
