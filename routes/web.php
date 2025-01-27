<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'loging')->name('login');
Route::view('/registro', 'register')->name('registro');
//Route::view('/privada', "secrets")-> name('privada');
Route::view('/privada', "secrets")->middleware('auth')-> name('privada');

Route::Post('/validarRegistro',[LoginController::class,'register'])->name('validarRegistro');
Route::Post('/iniciarSesion',[LoginController::class,'login'])->name('iniciarSesion');

Route::get('logout',[LoginController::class,'logout'])->name('logout');




