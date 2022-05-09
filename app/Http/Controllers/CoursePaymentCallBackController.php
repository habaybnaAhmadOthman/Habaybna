<?php

namespace App\Http\Controllers;
use App\Coursespurchaseorders;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursePaymentCallBackController extends Controller
{
   public function __invoke(Request $request)
   {
       
       $order = Coursespurchaseorders::whereTransactionid($request->Response_TransactionID)->first();
       dd(Auth::guard('web')->check());
       dd($order);
   }
}
