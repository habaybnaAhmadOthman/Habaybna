<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Providers\VerifyUser;





class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'unique:users'],
            'type' => ['required', 'string'],
        ]);

        $user = User::create([
            'role' => $request->type,
            // 'email' => $request->email,
            'phone' => $request->phone,
            'otp'=>random_int(100000, 999999),
        ]);
        if($user) {
          Auth::login($user);

            event(new VerifyUser($user->phone, $user->otp));

            return $user;
        }





        $userData['user'] =  $user;
        $userData['token'] =  $user->createToken('LaravelSanctumAuth')->accessToken;

        return response()->json(['userData' => $userData], 201);

    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);
        if(!Auth::attempt($request->only(['phone', 'password']))){
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }
        $user = User::where('phone', $request->phone)->first();

        $userType = $user->user_data;


        $token = $user->createToken('LaravelSanctumAuth');

        $userData['user'] =  $user;
        $userData['token'] =  $token->plainTextToken;
        if($userType){
            $userData['user']['firstName'] = $userType['firstName'];
            $userData['user']['lastName'] = $userType['lastName'];
        }

        return response($userData, 200);
    }

    public function logout(Request $request)
    {

        Auth::user()->tokens()->delete();
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function getProfileData(Request $request)
    {
        dd(Auth::user());
    }
}
