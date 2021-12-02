<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialist;
use App\Interest;
use Auth;
use Illuminate\Support\Facades\Hash;



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
}
