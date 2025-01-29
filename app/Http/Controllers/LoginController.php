<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller
{
    /**
     * Envía un código de verificación al correo del usuario.
     *
     * @param string $email Dirección de correo del usuario.
     * @return void
     */
    private function codeSend($email)
    {
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $mensaje = "Utiliza el código $code para verificar en nuestra aplicación.";

        try {
            Mail::raw($mensaje, function ($message) use ($email) {
                $message->to($email)->subject('Bienvenido a nuestra aplicación');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar el correo: ' . $e->getMessage());
        }

        Cache::put('codigo', Hash::make($code), config('codigos.TIEMPO_CODIGO'));
    }

    /**
     * Verifica el código ingresado por el usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function codeVerification(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $codigoGuardado = Cache::get('codigo');
        $contadorErrores = session('contadorErrores', 0);

        if (!$codigoGuardado) {
            return back()->with('error', 'El código ha expirado o no es válido.');
        }

        if (Hash::check($request->code, $codigoGuardado)) {
            session()->forget('contadorErrores');
            Cache::forget('codigo');
            $usuario = Cache::get('usuario');

            if (empty($usuario)) {
                $request->session();
                return redirect()->route('privada');
            }

            try {
                $user = new User();
                $user->name = $usuario['name'];
                $user->email = $usuario['email'];
                $user->password = Hash::make($usuario['password']);
                $user->rol = 'A';
                $user->save();
                Cache::forget('usuario');
                return redirect()->route('login')->with('success', 'Usuario registrado correctamente.');
            } catch (\Exception $e) {
                return redirect()->route('login')->with('error', 'Error al registrar el usuario: ');
            }
        }

        $contadorErrores++;
        session(['contadorErrores' => $contadorErrores]);

        if ($contadorErrores >= 3) {
            session()->forget('contadorErrores');
            Cache::forget('codigo');
            return redirect()->route('registro')->with('error', 'Has alcanzado el límite de intentos.');
        }

        return back()->with('error', 'El código ingresado es incorrecto.');
    }

    /**
     * Registra un usuario y envía un código de verificación.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        

        Cache::forget('codigo');
        Cache::forever('usuario', $validatedData);
        $this->codeSend($validatedData['email']);
        return redirect()->intended(route('verificacion'));
    }

    /**
     * Inicia sesión un usuario, valida las credenciales
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validar los campos de email y contraseña
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required', // Validar que el reCAPTCHA se haya resuelto
        ]);
    
        // Validar el token de reCAPTCHA
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY'); // Asegúrate de tener la clave secreta de reCAPTCHA en tu archivo .env
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptchaVerificationUrl = 'https://www.google.com/recaptcha/api/siteverify';
    
        $response = Http::asForm()->post($recaptchaVerificationUrl, [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
        ]);
    
        $recaptchaData = $response->json();
    
        // Verifica si el reCAPTCHA es válido
        if (!$recaptchaData['success']) {
            return redirect()->route('login')->with('error', 'Por favor, resuelve el CAPTCHA.');
        }
    
        // Obtener las credenciales del usuario
        $credenciales = $request->only('email', 'password');
    
        // Intentar autenticar al usuario
        if (Auth::attempt($credenciales)) {
            Cache::forget('codigo');
            $this->codeSend($credenciales['email']);
            return redirect()->intended(route('verificacion'));
        }
    
        // Si las credenciales son incorrectas
        return redirect()->route('login')->with('error', 'Credenciales incorrectas');
    }

    /**
     * Cierra la sesión del usuario actual.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Cache::forget('email');
        Cache::forget('usuario');
        Cache::forget('codigo');
        Auth::logout();
        return redirect(route('login'));
    }
}
