<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallPurchaseOrders extends Model
{
    // public function callsAppointments()
    // {
    //     return $this->hasOne(CallsAppointments::class,'appointment_id');
    // }
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function specialist()
    {
        return $this->belongsTo(User::class,'specialist_id','id');
    }
}
