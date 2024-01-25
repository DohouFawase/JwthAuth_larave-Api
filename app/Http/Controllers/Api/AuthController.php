<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\Auth;

class AuthController extends Controller
{
    //Login (POST, Formdat)

    public function login(Request $request) 
    {
        //data Validation
        $request -> validate([
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        //JWtAuth and attempt

        $credentials = $request->only('email','password');
        $token = auth()->attempt($credentials);

        if(!$token) 
        {
                return response()->json([
                    'status' => 'error',
                    'messagge' => 'Unauthorized',
                ],401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

    }
 //Login (Register, Formdat)

    public function register(Request $request)  
    {
        //data Validation
        $request -> validate([
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);
        // Creation ds données utlisateurs dans la base données
        $user = User::create([
            'name'=> $request -> name,
            'email'=> $request -> email,
            'password' => Hash::make($request->password)
        ]);

        //Envoie de reponse sous forme de Json
       
        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur creer ave success',
        ]);

    }

     //Profile Api Get Token

     public function profile()
      {

     }




     //Refresh Api Get Token

     public function refreshToken()
      {

     }



   
}
