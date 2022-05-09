<?php

namespace App\Http\Controllers;

use App\Other;
use App\User;
use App\Interest;
use App\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Auth;


class OthersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $otherUser = new Other();

        $otherUser->user_id = Auth::user()->id;
        $otherUser->firstName = $request->fristName;
        $otherUser->lastName = $request->lastName;
        $otherUser->gender = $request->gender ;
        $otherUser->specialization = '' ;
        $otherUser->work_place = '' ;
        $otherUser->employment = $request->employment ;
        $otherUser->why_to_join = $request->whyToJoin ;

        $otherUser->save();

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

    public function createOtherAdmin(Request $request)
    {
        // dd($request->lastName);
        $request->validate([
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'employment' => ['required', 'string'],
            'password' => ['required', 'string','min:8'],
           ]);

           $user = new User();
            $user->phone = '+'.$request->phone ;
            $user->email = $request->email ;
            $user->password = Hash::make($request->password);
            $user->otp = '123432' ;
            $user->role = 'other' ;
            $user->is_verify = 1 ;

            $user->save();

            if($user){
                $other = new Other();

                $other->user_id = $user->id;
                $other->firstName = $request->firstName;
                $other->lastName = $request->lastName;
                $other->gender = $request->gender ;
                $other->specialization = '' ;
                $other->work_place = '' ;
                $other->employment = $request->employment ;
                $other->why_to_join = '' ;


                $other->save();

                // send password by email to the parent

                return response()->json(
                    200
                );


            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function edit(Other $other)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try{

            $other = Other::where('user_id',$id)->first();

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

            $other->dob = $request->dob ;
            $other->specialization = $request->specialization ;
            $other->work_place = $request->workPlace ;
            $other->job_title = $request->jobTitle ;
            $other->employment = $request->employment ;
            $other->gender = $request->gender ;
            $other->why_to_join = $request->whyToJoin ;
            $other->edu_level = $request->education ;
            $other->specialization = 'others' ;

            // interest

            $other->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function destroy(Other $other)
    {
        //
    }

    public function editProfileData(Request $request)
    {
        try{

            $other = Auth::user()->user_data ;

            if(count($request->interests) > 0 ){
                $oldInterest = UserInterest::where('user_id',Auth::id() )->get() ;

                if(count($oldInterest) > 0 ){
                    foreach ($oldInterest as $old) {
                    $old->delete();
                    }
                }

                foreach ($request->interests as $interest) {
                    $userInterest = new UserInterest();
                    $userInterest->user_id = Auth::id();
                    $userInterest->interest_id = $interest;

                    $userInterest->save();
                 }


            }

            $other->dob = $request->dob ;
            $other->gender = $request->gender ;
            $other->edu_level = $request->education ;
            $other->employment = $request->employment ;
            $other->job_title = $request->jobTitle ;
            $other->work_place = $request->workPlace ;
            $other->why_to_join = $request->whyToJoin ;

            // interest

            $other->save();

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

    public function getOthersData()
    {
        try{
            $others = Other::all();
            // dd($others);
            $data = [];
            foreach ($others as  $other) {
                $other->user->toArray();
                $other->toArray();
                array_push($data,$other);
            }

            return response()->json([
                'others'=>$data
            ],200);
        } catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
        ]);
        }
    }
}
