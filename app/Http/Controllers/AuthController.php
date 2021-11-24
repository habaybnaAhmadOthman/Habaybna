<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'type' => ['required', 'string'],
        ]);
        $user = User::create([
            'role' => $request->type,
            'email' => $request->email,
            'phone' => $request->phone,
            'otp'=> 000111 //random_int(100000, 999999),
        ]);
        $user->save();
        // $accessToken = $user->createToken('authToken')->access_token ;

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        dd('xxxxx');
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = request(['phone', 'password']);

            if(!Auth::attempt($credentials))
            {
                if ($request->is('api/*')) {

                    return response()->json([
                        'message' => 'Unauthorized'
                    ], 401);
                }
                return view('auth.login');
            }
            // $user = $request->user();
            // $access_token = $user->createToken('Personal Access Token')->accessToken;




            if ($request->is('api/*')) {
                return response([
                    // 'access_token' => $access_token,
                    // 'token_type' => 'Bearer',
                    // 'expires_at' => Carbon::parse(
                    //     $tokenResult->token->expires_at
                    // )->toDateTimeString()
                ]);
            }
        if (! auth()->check() ) {
            return redirect()->to( '/auth/login' );
        }

        if (auth()->user()->role === "parent") {
            return redirect()->to( '/parent-dashboard' );
        }
        if (auth()->user()->role === "admin") {
            return redirect()->to( '/admin' );
        }


    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
