<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = ['usage_count'];

    public function users()
    {
        return $this->hasMany(AssignedCoupons::class,'coupon_id');
    }

    public function users_promo_codes()
    {
        return $this->hasMany(UsersPromoCode::class,'coupon_id');
    }
}
