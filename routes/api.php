<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [AuthController::class, 'register'])->name('registerjwt');
Route::post('login', [AuthController::class, 'login'])->name('loginjwt');


//protected routes
Route::middleware('jwt.verify')->group(function(){
    Route::get('users', [UserController::class, 'index']);

    Route::get('images', [ImageController::class, 'index']); // Leer
    Route::get('images/{id}/view', [ImageController::class, 'viewImage']); // Ver imagen
    Route::post('images', [ImageController::class, 'store']); // Crear
    Route::put('images/{id}', [ImageController::class, 'update']); // Actualizar
    Route::delete('images/{id}', [ImageController::class, 'destroy']); // Eliminar

});
