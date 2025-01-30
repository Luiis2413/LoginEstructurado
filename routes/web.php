<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/**
 * Muestra la vista de verificación de código.
 *
 * @return \Illuminate\View\View
 */
Route::view('/verificacion', 'codigoVerificacion')->name('verificacion');

/**
 * Muestra la vista de inicio de sesión.
 *
 * @return \Illuminate\View\View
 */
Route::view('/login', 'loging')->name('login');

/**
 * Muestra la vista de registro.
 *
 * @return \Illuminate\View\View
 */
Route::view('/registro', 'register')->name('registro');

/**
 * Muestra la vista privada solo para usuarios autenticados.
 *
 * @return \Illuminate\View\View
 */
Route::view('/privada', "secrets")->middleware('auth')->name('privada');

/**
 * Procesa la validación del código de registro.
 *
 * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos del usuario.
 * @return \Illuminate\Http\JsonResponse
 */
Route::post('/validarRegistro', [LoginController::class, 'codeSend'])->name('validarRegistro');

/**
 * Procesa el inicio de sesión del usuario.
 *
 * @param \Illuminate\Http\Request $request La solicitud HTTP con credenciales del usuario.
 * @return \Illuminate\Http\JsonResponse
 */
Route::post('/iniciarSesion', [LoginController::class, 'login'])->name('iniciarSesion');

/**
 * Verifica el código de autenticación enviado al usuario.
 *
 * @param \Illuminate\Http\Request $request La solicitud HTTP con el código de verificación.
 * @return \Illuminate\Http\JsonResponse
 */
Route::post('/verificarCodigo', [LoginController::class, 'codeVerification'])->name('verificarCodigo');

/**
 * Registra un nuevo usuario en el sistema.
 *
 * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos de registro.
 * @return \Illuminate\Http\JsonResponse
 */
Route::post('/registrar', [LoginController::class, 'register'])->name('registrar');

/**
 * Cierra la sesión del usuario autenticado.
 *
 * @return \Illuminate\Http\RedirectResponse
 */
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
