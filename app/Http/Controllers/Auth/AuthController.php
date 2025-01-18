<?php

namespace App\Http\Controllers\Auth;
//librerias
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
//modelo
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Funcion para registro de usuarios
     */
    public function register(Request $request){
        //validaciones
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
        //creacion de usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        //obtener token
        $token = JWTAuth::fromUser($user);
        //redireccionar a login
        return redirect()->route('login')->with('alert', 'Usuario registrado con éxito!');
    }

    /**
     * Funcion para loguearse
     */
    public function login(LoginRequest $request){
        //definir credenciales de logueo
        $credencials = $request->only('email', 'password');
        //verificar credenciales
        try{
            //si las credenciales son correctas obtengo un token
            if(!$token = JWTAuth::attempt($credencials)){
                return response()->json([
                    'error' => 'credenciales invalidas'
                ], 400);
            }
        }catch(JWTException $e){
            //mostrar error
            return response()->json([
                'error' => 'no creo el token'
            ], 500);
        }
        //enviar token
        return response()->json(compact('token'));
    }
}
