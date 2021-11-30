<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\User;
use App\Specialist;
// use App\Specialist;



class UserController extends Controller
{
    public function getUserData()
    {
        try{
            $user = Auth::user();
            // dd($user->user_data);
            switch ($user->role) {
                case 'parent':
                    $userData = [] ;
                    dd($user->user_data);
                    $userData['firstName'] = $user->user_data->firstName ;
                    $userData['lastName'] = $user->user_data->lastName ;
                    $userData['gender'] = $user->user_data->gender ;
                    $userData['dob'] = $user->user_data->dob ;
                    $userData['avatar'] = $user->user_data->avatar ;
                    $userData['status'] = $user->user_data->status ;
                    $userData['relative'] = $user->user_data->relative ;
                    $userData['childs_count'] = $user->user_data->childs_count ;
                    $userData['speci_childs_count'] = $user->user_data->speci_childs_count ;
                    $userData['edu_level'] = $user->user_data->edu_level ;
                    $userData['city'] = $user->user_data->city ;
                    $userData['employment'] = $user->user_data->employment ;
                    $userData['job_title'] = $user->user_data->job_title ;
                    $userData['why_to_join'] = $user->user_data->why_to_join ;
                    $userData['private_mode'] = $user->user_data->private_mode ;



                    $userData['phone'] = $user->phone ;
                    $userData['email'] = $user->email ;

                    break;

                default:
                    # code...
                    break;
            }


















            return response()->json([
                 'msg'=>'success',
                 'userData'=>$userData,
                 'status'=>true,
                 200
            ]);
        } catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404

           ]);
        }
    }
}
