<?php

namespace App\Http\Controllers;
//librerias
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//modelos
use App\Models\User;

class UserController extends Controller
{
    /**
     * Funcion para obtener usuario
     */
    public function index()
    {
        //obtener usuario autenticado
        $user_id = Auth::id();
        $user = User::find($user_id);
        //enviar datos de usuario
        return response()->json($user);
    }

    /**
     * Funcion para mostrar vista que consume el api
     */
    public function getImages()
    {
        //vista que consume el api
        return view('images');
    }
}
