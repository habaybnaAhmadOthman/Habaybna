<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentChildInfo extends Model
{
    protected $primaryKey = 'appointment_id';

    public function callsAppointments ()
    {
        return $this->belongsTo(CallsAppointments::class,'id','appointment_id');
    }
}
