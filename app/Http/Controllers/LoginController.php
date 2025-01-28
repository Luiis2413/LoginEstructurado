<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;




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
    public function codeSend(Request $request)
{
    $code = "";
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
    ]);
    $code=str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    // Verificar si los datos validados no son null y contienen la clave esperada
    if (!$validatedData || !isset($validatedData['name']) || !isset($validatedData['email'])) {
        return redirect()->back()->with('error', 'Error: Los datos no son válidos.');
    }

    // Si todo está bien, procede con el envío del correo
    $nombre = $validatedData['name'];
    $correo = $validatedData['email'];
    $mensaje = "Hola $nombre, Utiliza el codigo $code para verificar en nuestra aplicación.";

    //dd($validatedData);  // Esto imprimirá los datos para verificar qué contiene.


    // Enviar correo de texto plano
    Mail::raw($mensaje, function ($message) use ($correo) {
        $message->to($correo)
                ->subject('Bienvenido a nuestra aplicación');
    });


    $TIEMPO_CODIGO = config('codigos.TIEMPO_CODIGO');
    Cache::put('codigo',Hash::make($code) , $TIEMPO_CODIGO);
    Cache::put('usuario',$validatedData,$TIEMPO_CODIGO);

    return redirect()->route('verificacion');

}


public function codeVerification(Request $request)
{
    // Validar entrada del usuario
    $request->validate([
        'code' => 'required|string',
    ]);

    $codigoGuardado = Cache::get('codigo'); // Obtener código en caché
    $contadorErrores = session('contadorErrores', 0); // Obtener contador desde la sesión

    // Verificar si el código está en caché
    if (!$codigoGuardado) {
        return back()->with('error', 'El código ha expirado o no es válido.');
    }

    // Verificar si el código ingresado es correcto
    if (Hash::check($request->code, $codigoGuardado)) {
        // Reiniciar sesión y eliminar código si es correcto
        session()->forget('contadorErrores');
        Cache::forget('codigo');
        return redirect()->route('login')->with('success', 'Código verificado correctamente.');
    } else {
        $contadorErrores++;
        session(['contadorErrores' => $contadorErrores]); // Actualizar contador

        // Si alcanza el límite de intentos
        if ($contadorErrores >= 3) {
            session()->forget('contadorErrores'); // Reiniciar contador
            Cache::forget('codigo'); // Eliminar código en caché
            return redirect()->route('registro')->with('error', 'Has alcanzado el límite de intentos.');
        }

        return back()->with('error', 'El código ingresado es incorrecto.');
    }
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
