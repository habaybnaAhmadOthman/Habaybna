<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stevebauman\Location\Facades\Location;


use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getUserCountry(Request $request)
    {
        // request()->ip() ::: 37.220.117.144
        try {
            $position = Location::get(request()->ip());
            return response()->json([
                'msg'=>'success',
                'status'=>true,
                'data'=>$position,
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
