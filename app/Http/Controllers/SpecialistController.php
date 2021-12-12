<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialist;
use App\Interest;
use App\UserInterest;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;




class SpecialistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $specialist = new Specialist();

        $specialist->user_id = Auth::user()->id;
        $specialist->firstName = $request->fristName;
        $specialist->lastName = $request->lastName;
        $specialist->gender = $request->gender ;
        $specialist->specialization = $request->specialization ;
        $specialist->work_place = $request->workPlace ;

        $specialist->save();

        Auth::user()->email = $request->email;
        Auth::user()->password = Hash::make($request->password) ;
        Auth::user()->save();

        $interest = Interest::all();

        return response()->json([
            'msg'=>'success',
            'status'=>true,
            'userData'=>Auth::user(),
            'intrest'=>$interest,
            200
        ]);
    }

    public function editProfileData(Request $request)
    {
        try{

            $specialist = Auth::user()->user_data ;

            $specialist->dob = $request->dob ;
            $specialist->specialization = $request->specialization ;
            $specialist->work_place = $request->workPlace ;
            $specialist->job_title = $request->jobTitle ;
            $specialist->experience = $request->experience ;
            $specialist->gender = $request->gender ;
            $specialist->disorders_work_with = $request->whyToJoin ;
            $specialist->edu_level = $request->education ;

            // interest

            $specialist->save();

            return response()->json([
                'msg'=>'success',
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

    public function getSpecialistsData()
    {

        try{
            $specialists = Specialist::all();
            $data = [];
            foreach ($specialists as  $specialist) {
                $specialist->user->toArray();
                $specialist->toArray();
                array_push($data,$specialist);
            }

            return response()->json([
                'specialists'=>$data
            ],200);
        } catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
        ]);
        }

    }

    public function show($id)
    {
        try {
            $user = User::findorfail($id);
            $userIntrest = UserInterest::where('user_id',$user->id )->get() ;
            $interestsList = Interest::all();

            if($userIntrest){
                $userIntrests = [];
                foreach ($userIntrest as $one) {
                    $userIntrests[] =
                    [
                    'id'=> $one->intrest_data->id,
                    'title'=>$one->intrest_data->title,
                    ];
                }

            }

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
            return response()->json([
                'msg'=>'success',
                'userData'=>$userData,
                'status'=>true,
                200
            ]);

        }catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
           ]);
        }
    }

    public function update(Request $request, $id)
    {
        try{

            $specialist = Specialist::where('user_id',$id)->first();

            if(count($request->interests) > 0 ){
                $oldInterest = UserInterest::where('user_id',$id )->get() ;

                if(count($oldInterest) > 0 ){
                    foreach ($oldInterest as $old) {
                    $old->delete();
                    }
                }

                foreach ($request->interests as $interest) {
                    $userInterest = new UserInterest();
                    $userInterest->user_id = $id;
                    $userInterest->interest_id = $interest;

                    $userInterest->save();
                 }


            }

            $specialist->dob = $request->dob ;
            $specialist->specialization = $request->specialization ;
            $specialist->work_place = $request->workPlace ;
            $specialist->job_title = $request->jobTitle ;
            $specialist->experience = $request->experience ;
            $specialist->gender = $request->gender ;
            $specialist->disorders_work_with = $request->whyToJoin ;
            $specialist->edu_level = $request->education ;

            // interest

            $specialist->save();

            return response()->json([
                'msg'=>'success',
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
