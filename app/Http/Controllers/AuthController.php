<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;




class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // dd($request);
        $request->validate([
            'phone' => ['required', 'unique:users'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'type' => ['required', 'string'],
        ]);
        $user = User::create([
            'role' => $request->type,
            // 'email' => $request->email,
            'phone' => $request->phone,
            'otp'=> 000111 //random_int(100000, 999999),
        ]);
        // $user->save();
        //  $user->createToken(random_int(100000, 999999))->planeTextTokens;
        //  return  $user->createToken($request->phone)->token->id;

        // $token =  $user->createToken($request->phone);
        // dd(Auth::user());
        // $token = $user->createToken($request->phone);

        $userData['user'] =  $user;
        $userData['token'] =  $user->createToken('LaravelSanctumAuth')->accessToken;

        // $accessToken = $user->createToken('authToken')->access_token ;

        // return response()->json([
        //     'message' => 'Successfully created user!'
        // ], 201);
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
        $user = User::where('phone', $request->phone)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }
        $userType = $user->user_data;

        $user->tokens()->delete();

        $token = $user->createToken('vue web')->accessToken;

        $userData['user'] =  $user;
        $userData['token'] =  $token;

        if($userType){
            $userData['user']['firstName'] = $userType['firstName'];
            $userData['user']['lastName'] = $userType['lastName'];
        }

        return response()->json(['userData' => $userData], 200);
    }

    public function logout(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->tokens()->delete();
        // Auth::logout();
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
