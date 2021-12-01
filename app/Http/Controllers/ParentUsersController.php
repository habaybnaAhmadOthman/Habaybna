<?php

namespace App\Http\Controllers;

use App\ParentUsers;
use App\Interest;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;



class ParentUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // dd('xxxxxxxx');
        // $this->middleware('auth:sanctum');
    }


    public function index()
    {
        // parents dashboard
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function show(ParentUsers $parentUsers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function edit(ParentUsers $parentUsers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParentUsers $parentUsers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ParentUsers  $parentUsers
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParentUsers $parentUsers)
    {
        //
    }

    public function completeRegister(Request $request)
    {
        $parent = new ParentUsers() ;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $filename = 'profile-photo-' . time() . '.' . $img->getClientOriginalExtension();
            $path = $img->storeAs('avatars', $filename);
        }

        $parent->user_id = Auth::user()->id ;
        $parent->firstName = $request->firstName ;
        $parent->lastName = $request->lastName ;
        $parent->gender = $request->gender ;
        $parent->relative = $request->relative ;
        // $parent->avatar = $path ? $path  : '';

        $parent->save();
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

    public function onlineCourses()
    {
        return view('parents.onlineCourses');
    }
}
