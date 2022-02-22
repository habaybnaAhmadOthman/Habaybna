<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    public function users()
    {
        return $this->hasMany(AssignedCoupons::class,'coupon_id');
    }
}
