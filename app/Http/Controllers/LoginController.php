<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Registra un nuevo usuario.
     *
     * Este método maneja la creación de un nuevo usuario, asigna un rol, 
     * encripta la contraseña y guarda al usuario en la base de datos. 
     * Opcionalmente, puede iniciar sesión automáticamente después del registro.
     *
     * @param Request $request La solicitud HTTP que contiene los datos del usuario.
     * @return \Illuminate\Http\RedirectResponse Redirige a la página de inicio de sesión.
     */
    public function register(Request $request)
    {
        // Asignar un rol por defecto al usuario
        $rol = 'A'; // Asignación estática, puede ser dinámica según la lógica del negocio

        // Crear una nueva instancia de usuario
        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password); // Encriptar la contraseña
        $user->email = $request->email;
        $user->rol = $rol;

        // Guardar el usuario en la base de datos
        $user->save();

        // Redirigir a la página de inicio de sesión después del registro
        return redirect(route('login'));
    }

    /**
     * Inicia sesión un usuario.
     *
     * Este método valida las credenciales del usuario e intenta iniciar sesión. 
     * Si tiene éxito, regenera la sesión y redirige a una ruta privada. 
     * De lo contrario, redirige de vuelta a la página de inicio de sesión.
     *
     * @param Request $request La solicitud HTTP que contiene las credenciales de inicio de sesión.
     * @return \Illuminate\Http\RedirectResponse Redirige a la página privada o a la página de inicio de sesión.
     */
    public function login(Request $request)
    {
        // Validar credenciales
        $credenciales = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        // Intentar iniciar sesión
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate(); // Regenerar la sesión para prevenir fijación de sesión
            return redirect()->intended(route('privada')); // Redirigir a la página privada
        } else {
            // Redirigir de vuelta a la página de inicio de sesión en caso de fallo
            return redirect(route('login'));
        }
    }

    /**
     * Cierra la sesión del usuario actual.
     *
     * Este método cierra la sesión del usuario autenticado e invalida la sesión. 
     * Luego redirige a la página de inicio de sesión.
     *
     * @return \Illuminate\Http\RedirectResponse Redirige a la página de inicio de sesión.
     */
    public function logout()
    {
        // Cerrar la sesión del usuario
        Auth::logout();

        // Redirigir a la página de inicio de sesión
        return redirect(route('login'));
    }
}
