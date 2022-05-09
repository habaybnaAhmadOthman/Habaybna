<?php

namespace app\CustomClass;

use App\AssignedCoupons;
use App\PromoCode;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class AssignToUsers {

    public function execute($data)
    {
        try {
            if($data){
                foreach ($data->user_id as $one) {
                    $coupon = new AssignedCoupons();
                    $coupon->user_id = $one;
                    $coupon->coupon_id = $data->coupon_id;
                    $coupon->save();
                }
            }

            return true;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
