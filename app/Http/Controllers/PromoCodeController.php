<?php

namespace App\Http\Controllers;

use App\PromoCode;
use Illuminate\Http\Request;
use App\CustomClass\createCoupon;
use App\CustomClass\editCoupon;
use App\CustomClass\AssignToUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class PromoCodeController extends Controller

{
    public function index()
    {
        try{
            $coupons = PromoCode::all();
            $data = [];
            foreach ($coupons as $key ) {
                $data [] = [
                    'id'=>$key->id,
                    'code'=>$key->code,
                    'usage'=>$key->usage,
                    'type'=>$key->type,
                    'status'=>$key->status,
                    'max_usage'=>$key->max_usage,
                    'discount_percentage'=>$key->discount_percentage,
                    'start_date'=>unserialize($key->date)->start,
                    'end_date'=>unserialize($key->date)->end,
                    'usage_count'=>$key->usage_count,
                    'usage_count'=>$key->usage_count,
                ];
            }
            return response()->json($data, 200);
        } catch (ModelNotFoundException $e){
            return response()->json(
                false,
                404
           );
        }

    }
    public function show($id)
    {
        try{
            $coupons = PromoCode::findorfail($id);
            $data = [];
                $data  = [
                    'id'=>$coupons->id,
                    'code'=>$coupons->code,
                    'usage'=>$coupons->usage,
                    'type'=>$coupons->type,
                    'status'=>$coupons->status,
                    'max_usage'=>$coupons->max_usage,
                    'discount_percentage'=>$coupons->discount_percentage,
                    'start_date'=>unserialize($coupons->date)->start,
                    'end_date'=>unserialize($coupons->date)->end,
                    'usage_count'=>$coupons->usage_count,
                    'usage_count'=>$coupons->usage_count,
                ];
            return response()->json($data, 200);
        } catch (ModelNotFoundException $e){
            return response()->json(
                false,
                404
           );
        }
    }
    public function create(Request $request,createCoupon $createCoupon )
    {
        $coupon = $createCoupon->execute($request->all());

        return response()->json($coupon, 200);
    }

    public function assignToUsers(Request $request, AssignToUsers $assignToUsers)
    {
        $assignToUsers->execute($request);

        return response()->json(true,200);

    }

    public function update(Request $request,$id, editCoupon $editCoupon )
    {
        $coupon = $editCoupon->execute($request->all(), $id);

        return response()->json($coupon, 200);
    }

    public function delete($id)
    {
        try{
            $coupon = PromoCode::findorfail($id);
            if(count($coupon->users) > 0 ){
                foreach ($coupon->users as $key) {
                    $key->delete();
                }
            }
            $coupon->delete();
            return response()->json(true, 200);
        } catch (ModelNotFoundException $e){
            return response()->json(
                false,
                404
           );
        }
    }

    public function changeStatus($id)
    {
        try{
            $coupon = PromoCode::findorfail($id);
                    $coupon->status = !$coupon->status;
                    $coupon->save();

            return response()->json('changged',200);

        } catch (ModelNotFoundException $e){
            return response()->json(
               false,
                404
           );

        }
    }
}
