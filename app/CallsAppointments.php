<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallsAppointments extends Model
{
    protected $fillable = ['specialist_id','appointment'];
    protected $primaryKey = 'specialist_id';

    public function specialist()
    {
        return $this->belongsTo(Specialist::class,'user_id');
    }

    public function callsStatus()
    {
        return $this->hasOne(CallsStatus::class,'appointment_id', 'id');
    }

    public function appointmentChildInfo()
    {
        return $this->hasOne(AppointmentChildInfo::class,'appointment_id','id');
    }

    public function callPurchaseOrders()
    {
        return $this->belongsTo(CallPurchaseOrders::class,'id','appointment_id')->where('status',true);
    }
}
