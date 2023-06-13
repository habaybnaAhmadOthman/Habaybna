<?php

namespace app\CustomClass;

use App\PromoCode;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class CheckPromoCode {

    public function execute(array $data)
    {

        try {
            $code = PromoCode::whereCode($data['promoCode'])->first();
            $couponData = [];
                if(isset($code)){
                    if($data['usage'] == $code->usage ){
                        if($code->usage_count < $code->max_usage){
                            if($code->status){
                                $now = Carbon::now()->isoFormat('YYYY-MM-DD');
                                $expDate = unserialize($code->date)->end;

                                if($now <= $expDate) {
                                    if($code->type == 'free'){
                                        return  $couponData['couponData'] =
                                                [
                                                    'id'=>$code->id,
                                                    'code'=>$code->code,
                                                    'isValid'=>true,
                                                    'usage'=>$code->usage,
                                                    'discount_perc'=>100,
                                                    'msg'=>'success'
                                                ];
                                     }
                                    if($code->type == 'discount'){
                                        return  $couponData['couponData'] =
                                                [
                                                    'id'=>$code->id,
                                                    'code'=>$code->code,
                                                    'isValid'=>true,
                                                    'usage'=>$code->usage,
                                                    'discount_perc'=>$code->discount_percentage,
                                                    'msg'=>'success'
                                                ];
                                    }
                                }
                                // to handel expire code (if code is expire)
                                return  $couponData['couponData'] =
                                [
                                    'id'=>$code->id,
                                    'code'=>$code->code,
                                    'isValid'=>false,
                                    'usage'=>$code->usage,
                                    'discount_perc'=> 0,
                                    'msg'=>'expire'

                                ];
                            }
                            // to handel not active promo (if code status false)
                            return  $couponData['couponData'] =
                            [
                                'id'=>$code->id,
                                'code'=>$code->code,
                                'isValid'=>false,
                                'usage'=>$code->usage,
                                'discount_perc'=>0,
                                'msg'=>'inactive'

                            ];
                        }
                        // to handel max usage ( if max_usage <= usage_count )
                        return  $couponData['couponData'] =
                        [
                            'id'=>$code->id,
                            'code'=>$code->code,
                            'isValid'=>false,
                            'usage'=>$code->usage,
                            'discount_perc'=>0,
                            'msg'=>'maxUsageReached'
                        ];
                    }
                    // to handel users coupon
                    if($code->usage == 'Users' ) {

                        if($code->status){


                            $haveCode = array_search(Auth::id(),$code->users->pluck('user_id')->toArray());
                            if($haveCode === false){
                                return  $couponData['couponData'] =
                                [
                                    'id'=>$code->id,
                                    'code'=>$code->code,
                                    'isValid'=>false,
                                    'usage'=>$code->usage,
                                    'discount_perc'=> 0,
                                    'msg'=>'notHave'

                                ];

                            }
                            $now = Carbon::now()->isoFormat('YYYY-MM-DD');
                            $expDate = unserialize($code->date)->end;

                            if($now <= $expDate) {
                                if($code->type == 'free'){
                                    return  $couponData['couponData'] =
                                            [
                                                'id'=>$code->id,
                                                'code'=>$code->code,
                                                'isValid'=>true,
                                                'usage'=>$code->usage,
                                                'discount_perc'=>100,
                                                'msg'=>'success'
                                            ];
                                 }
                                if($code->type == 'discount'){
                                    return  $couponData['couponData'] =
                                            [
                                                'id'=>$code->id,
                                                'code'=>$code->code,
                                                'isValid'=>true,
                                                'usage'=>$code->usage,
                                                'discount_perc'=>$code->discount_percentage,
                                                'msg'=>'success'
                                            ];
                                }
                            }
                            return  $couponData['couponData'] =
                            [
                                'id'=>$code->id,
                                'code'=>$code->code,
                                'isValid'=>false,
                                'usage'=>$code->usage,
                                'discount_perc'=> 0,
                                'msg'=>'expire'

                            ];
                        }
                    }
                    return  $couponData['couponData'] =
                    [
                        'id'=>$code->id,
                        'code'=>$code->code,
                        'isValid'=>false,
                        'usage'=>$code->usage,
                        'discount_perc'=>0,
                        'msg'=>'coursePromoCode'
                    ];
                }
                // to handel not found promo
                return  $couponData['couponData'] =
                [
                    'isValid'=>false,
                    'discount_perc'=>0,
                    'msg'=>'promoNotFound'
                ];

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
