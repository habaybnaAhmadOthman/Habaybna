<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;




use Illuminate\Http\Request;

class CheckUserAuth extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        dd('xxxx');
        if (Auth::check()) {
            $user = Auth::user();
            $userData['avatar']= 'avatar';
            $userData['firstName']= $user->user_data->firsName;
            $userData['lasttName']= $user->user_data->lastName;
            $userData['type']= $user->role;
            return response()->json([
                'status'=>true,
                'msg'=>'success',
                'userData'=>$userData
            ]);
        }
        try{
    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404
       ]);
    }


    }
}
