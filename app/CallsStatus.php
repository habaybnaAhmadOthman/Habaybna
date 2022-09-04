<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallsStatus extends Model
{
    public function callAppointment()
    {
        // return $this->belongsTo(CallsAppointments::class,'id','appointment_id');
        return $this->belongsTo(CallsAppointments::class,'appointment_id','id');
    }
}
