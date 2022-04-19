<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
// use App\Http\Controllers\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stevebauman\Location\Facades\Location;
use App\Providers\VerifyUser;
use Illuminate\Support\Facades\Hash;





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

    public function ckUploadImages(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            // $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename = str_replace(' ', '', pathinfo($filenamewithextension, PATHINFO_FILENAME));

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File
            $request->file('upload')->storeAs('public/images/media/', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/images/media/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            // @header('Content-type: text/html; charset=utf-8');
            return response([$url] ,200);
        }
    }

    public function forgetPassword (Request $request) {
        if($request->mobileNumber && $request->mobileNumber != ""){
            $user = User::where('phone',$request->mobileNumber)->first();
                if($user){
                    $user->otp = random_int(100000, 999999);
                    $user->save();
                    event(new VerifyUser($user->phone, $user->otp));

                    return response($user->phone,200);

                }
                return response('invalidPhoneNumber',403);

        }
        return response('invalidPhoneNumber',403);

    }

    public function checkForgetPassword (Request $request) {

        if($request->mobileNumber && $request->mobileNumber != ""){
            $user = User::where('phone',$request->mobileNumber)->first();
                if($user){
                    if($user->otp == $request->otp){
                        $user->is_verify = 1 ;
                        $user->save() ;
                        return response($user->phone,200);
                    }
                    return response('invalidOtp',403);
                }

        }
        return response('invalidOtp',403);

    }

    public function changePassword (Request $request) {

        if($request->mobileNumber && $request->mobileNumber != ""){
            $user = User::where('phone',$request->mobileNumber)->first();
                if($user && $user->is_verify){
                    $user->password = Hash::make($request->password) ;
                    $user->save() ;
                    return response($user->phone,200);
                }

                return response('notVerify',403);
        }
        return response('invalidPhoneNumber',403);

    }


}
