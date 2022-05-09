<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckOtp extends Controller
{
    public function __invoke(Request $request)
    {
       if(Auth::user()->otp !== $request->otpCode)
       {return response('faild',404);}


        Auth::user()->is_verify = true ;
        return response(200);

    }
}
