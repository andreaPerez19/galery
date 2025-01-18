<?php

namespace App\Http\Controllers\Auth;
//librerias
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//modelos
use App\Models\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Controlador para mostrar la vista de registro
    | 
    |
    */

    use RegistersUsers;
        
}
