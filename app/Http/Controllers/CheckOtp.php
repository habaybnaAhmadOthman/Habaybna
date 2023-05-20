<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckOtp extends Controller
{

    public function __invoke(Request $request)
    {
            // dd($request->session()->get('user.otp'));
       if($request->session()->get('user.otp') != $request->otpCode)
       {
           return response('faild',404);
        }
        // Auth::user()->is_verify = true ;
        else{

            return response(200);
        }

    }
}
