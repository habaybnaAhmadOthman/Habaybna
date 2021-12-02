<?php

namespace App\Http\Controllers;

use App\Other;
use App\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    public function show(Other $other)
    {
        //
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
    public function update(Request $request, Other $other)
    {
        //
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
}
