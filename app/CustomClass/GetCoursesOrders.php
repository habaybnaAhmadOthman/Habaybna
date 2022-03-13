<?php

namespace app\CustomClass;
use Illuminate\Support\Facades\Http;
use App\Courses;
use App\Coursespurchaseorders;
use App\PromoCode;
use App\User;
use Illuminate\Support\Facades\Auth;
class GetCoursesOrders {

    public function execute()
    {

        $allOrders = Coursespurchaseorders::all();
        dd($allOrders);



        try {


        } catch (\Throwable $th) {
            throw $th;
        }
    }



}
