<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::view('/verificacion', 'codigoVerificacion')->name('verificacion');
Route::view('/login', 'loging')->name('login');
Route::view('/registro', 'register')->name('registro');
//Route::view('/privada', "secrets")-> name('privada');
Route::view('/privada', "secrets")->middleware('auth')-> name('privada');

Route::Post('/validarRegistro',[LoginController::class,'codeSend'])->name('validarRegistro');
Route::Post('/iniciarSesion',[LoginController::class,'login'])->name('iniciarSesion');
Route::Post('/verificarCodigo',[LoginController::class,'codeVerification'])->name('verificarCodigo');
Route::Post('/registrar',[LoginController::class,'register'])->name('registrar');




Route::get('logout',[LoginController::class,'logout'])->name('logout');




