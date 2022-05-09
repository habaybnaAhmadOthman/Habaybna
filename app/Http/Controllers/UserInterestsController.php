<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInterest;
use Auth;

class UserInterestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $interests = $request->all();

        foreach ($interests as $interest) {
           $userInterest = new UserInterest();

           $userInterest->user_id = Auth::user()->id;
           $userInterest->interest_id = $interest;

           $userInterest->save();
        }
        return response()->json([
            'msg'=>'success',
            'status'=>true,
            'userData'=>Auth::user(),
             200
        ]);
    }
}
