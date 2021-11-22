<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInterest;

class UserInterestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {

        foreach ($request as $one) {
            $userInterest = new UserInterest();
            $userInterest->user_id = Auth::user()->id;
            $userInterest->interest_id = $one;
            $userInterest->save();
        }
    }
}
