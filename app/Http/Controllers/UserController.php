<?php

namespace App\Http\Controllers;

use App\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;


use App\User;
use App\Specialist;
use App\UserInterest;

// use App\Specialist;



class UserController extends Controller
{
    public function getUserData()
    {
        try{
            $user = Auth::user();
            // dd($user->user_data);
            $userIntrest = UserInterest::where('user_id',$user->id )->get() ;
            $interestsList = Interest::all();
            if($userIntrest){
                $userIntrests = [];
                foreach ($userIntrest as $intrest) {
                    $userIntrests[] =
                    [
                       'id'=> $intrest->intrest_data->id,
                       'title'=>$intrest->intrest_data->title,
                    ];
                }

            }

            switch ($user->role) {
                case 'parent':

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
                    $userData['interests'] = $userIntrests ? $userIntrests : '';
                    $userData['interestsList'] = $interestsList ? $interestsList : [];



                    $userData['phone'] = $user->phone ;
                    $userData['email'] = $user->email ;

                    break;

                case 'specialist':

                    $userData['firstName'] = $user->user_data->firstName ;
                    $userData['lastName'] = $user->user_data->lastName ;
                    $userData['gender'] = $user->user_data->gender ;
                    $userData['specialization'] = $user->user_data->specialization ;
                    $userData['work_place'] = $user->user_data->work_place ;
                    $userData['status'] = $user->user_data->status ;
                    $userData['avatar'] = $user->user_data->avatar ;
                    $userData['edu_level'] = $user->user_data->edu_level ;
                    $userData['job_title'] = $user->user_data->job_title ;
                    $userData['dob'] = $user->user_data->dob ;
                    $userData['experience'] = $user->user_data->experience ;
                    $userData['disorders_work_with'] = $user->user_data->disorders_work_with ;
                    $userData['interests'] = $userIntrests ? $userIntrests : '';
                    $userData['interestsList'] = $interestsList ? $interestsList : [];



                    $userData['phone'] = $user->phone ;
                    $userData['email'] = $user->email ;

                case 'other':
                    $userData['firstName'] = $user->user_data->firstName ;
                    $userData['lastName'] = $user->user_data->lastName ;
                    $userData['gender'] = $user->user_data->gender ;
                    // $userData['specialization'] = $user->user_data->specialization ;
                    $userData['work_place'] = $user->user_data->work_place ;
                    $userData['status'] = $user->user_data->status ;
                    $userData['avatar'] = $user->user_data->avatar ;
                    $userData['edu_level'] = $user->user_data->edu_level ;
                    $userData['job_title'] = $user->user_data->job_title ;
                    $userData['dob'] = $user->user_data->dob ;
                    $userData['why_to_join'] = $user->user_data->why_to_join ;
                    $userData['employment'] = $user->user_data->employment ;
                    $userData['interests'] = $userIntrests ? $userIntrests : '';
                    $userData['interestsList'] = $interestsList ? $interestsList : [];


                    $userData['phone'] = $user->phone ;
                    $userData['email'] = $user->email ;
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

    public function setNewPassword(Request $request)
    {
        $oldPassword = $request->oldPassword;
        $hashedPassword = Auth::user()->password;  // Taking the value from database

        if(Hash::check($oldPassword, $hashedPassword))
        {
             Auth::user()->password = Hash::make($request->newPassword) ;
             Auth::user()->save();

            return response()->json([
                'msg'=>'success',
                'status'=>true,
                200
            ]);
        }
        else
        {
            return response()->json([
                'msg'=>'old password not correct',
                'status'=>false,



           ],404);
        }
    }
}
