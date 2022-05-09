<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSpecialist extends Model
{
   public function specialist()
   {
       return $this->hasOne(Specialist::class,'user_id','specialist_id');
   }
}
