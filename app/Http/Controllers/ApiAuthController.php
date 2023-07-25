<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                "name" => "required|min:3",
                "email" => "required|email|unique:users",
                "password"=> "required|min:8|confirmed"
            ]
        );

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password"=> Hash::make($request->password)
        ]);

        return response()->json([
            "success" => true,
            "message" => "user registered successful"
        ],200);
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                "email" => "required|email",
                "password"=> "required|min:8"
            ]
        );

        if(!Auth::attempt($request->only("email","password"))){
            return response()->json([
                "message" => "email or password wrong"
            ],404);
        };

        return Auth::user()->createToken("api login");
    }

    public function logout()
    {

    }
}
