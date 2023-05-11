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

        try{
            if (Auth::check()) {
                if(Auth::user()->role == 'admin'){
                    return response()->json([
                        'status'=>true,
                        'msg'=>'success',
                        'userData'=>Auth::user(),
                        'type'=>'admin'
                    ]);
                }
                $user = Auth::user();
                if($user != null){
                    $userData['id']= $user->id;
                    $userData['avatar']= $user->user_data->avatar;
                    $userData['firstName']= $user->user_data->firstName;
                    $userData['lastName']= $user->user_data->lastName;
                    $userData['notifications']= $user->notifications;
                    $userData['type']= $user->role;
                    $userData['can_make_call']= $user->role == 'specialist' && $user->user_data->make_calls ? true : false ;
                    $userData['can_make_comment']= $user->role == 'specialist' && $user->user_data->can_make_comments ? true : false ;
                    return response()->json([
                        'status'=>true,
                        'msg'=>'success',
                        'userData'=>$userData
                    ]);
                }


            }
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
           ],404);

    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
        ],404);
    }


    }
}
