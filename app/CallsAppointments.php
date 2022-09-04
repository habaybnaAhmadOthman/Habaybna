<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallsAppointments extends Model
{
    protected $fillable = ['specialist_id','appointment'];
    protected $primaryKey = 'specialist_id';
    protected $appends = ['Parnet'];


    public function specialist()
    {
        return $this->belongsTo(Specialist::class,'specialist_id','user_id');
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

    public function getParnetAttribute()
    {
        if($this->callPurchaseOrders)
            return User::findorfail($this->callPurchaseOrders->user_id)
                ->makeHidden([
                    'password',
                    'created_at',
                    'email_verified_at',
                    'otp',
                    'is_verify',
                    'remember_token',
                    'updated_at',
                ]);
        return null ;

    }

}
