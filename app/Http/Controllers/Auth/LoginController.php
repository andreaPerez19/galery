<?php

namespace App\Http\Controllers\Auth;
//librerias
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controlador para la vista login
    | que va consumir el api de autenticacion
    |
    */

    use AuthenticatesUsers;
        
}
