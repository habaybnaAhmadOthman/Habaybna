<?php

namespace app\CustomClass;

use App\PromoCode;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class editCoupon {

    public function execute(array $data, $id)
    {
        try {
            $coupon = PromoCode::findorfail($id);

            if($coupon->code !== $data['code'] && PromoCode::whereCode($data['code'])->first() ) {
                return response()->json(409);
            }

            if($data['coupone_duration']){
                $date = new \stdClass();
                $date->start = date("Y-m-d", strtotime($data['coupone_duration'][0]));
                $date->end = date("Y-m-d", strtotime($data['coupone_duration'][1]));
                $date= serialize($date);
                $coupon->date = $date ;
            }

            $coupon->code = $data['code'];
            $coupon->usage = $data['usage'];
            $coupon->type = $data['type'];
            $coupon->status = $data['status'];
            $coupon->max_usage = $data['max_usage'];
            $coupon->discount_percentage = $data['type'] !== 'free' ? $data['discount_perc'] : 100 ;
            // $coupon->expiry_date = new date();
            // $coupon->expiry_date = $date ? $date : '';
            // $coupon->date = $date ? $date : '';


            $coupon->save();

            return $coupon;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
