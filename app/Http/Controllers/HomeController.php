<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Auth;
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
        $this->middleware('auth');
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
    public function checkOtp()
    {

        return view('checkOtp');
    }

    public function otpValidate(Request $request)
    {
        $otp = $request->otp;

        $user = Auth::user();

        if($user->otp === $otp) {
            $user->is_verify = true ;
            $user->save();
        }else {
            return redirect()->back()->with('msg', 'OTP virefication faild ');

        }

        switch ($user->role) {
            case 'parent':
                return redirect('/complete-register');
                break;

            case 'directory':
                dd('directory');

                break;

            case 'specialist':
                dd('specialist');

                break;

            default:

                break;
        }


    }
}
