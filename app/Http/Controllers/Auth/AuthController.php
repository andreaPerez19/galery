<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = JWTAuth::fromUser($user);
        
        return redirect()->route('login')->with('alert', 'Usuario registrado con éxito!');
    }

    public function login(LoginRequest $request){
        $credencials = $request->only('email', 'password');

        try{
            if(!$token = JWTAuth::attempt($credencials)){
                return response()->json([
                    'error' => 'credenciales invalidas'
                ], 400);
            }
        }catch(JWTException $e){
            return response()->json([
                'error' => 'no creo el token'
            ], 500);
        }

        return response()->json(compact('token'));
    }
}
