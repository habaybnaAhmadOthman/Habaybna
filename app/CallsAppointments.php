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
}
