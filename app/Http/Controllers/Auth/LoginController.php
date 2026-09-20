<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Procesa la autenticación del usuario.
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario.
        $datos = $request->validate([
            'identity' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        // Buscar al usuario mediante el correo de su persona.
        $usuario = Usuario::whereHas('persona', function ($query) use ($datos) {
            $query->where('email', $datos['identity']);
        })
        ->where('activo', true)
        ->first();

        // Comprobar que existe y que la contraseña es correcta.
        if (!$usuario || !Hash::check($datos['password'], $usuario->password)) {
            throw ValidationException::withMessages([
                'identity' => 'Las credenciales proporcionadas son incorrectas.',
            ]);
        }

        // Actualizar el último acceso del usuario.
        $usuario->forceFill([
            'ultimo_acceso' => now(),
        ])->save();

        // Iniciar la sesión.
        Auth::login($usuario, $request->boolean('remember'));

        // Regenerar la sesión por seguridad.
        $request->session()->regenerate();

        // Redirigir al panel del consultor.
        return redirect()->intended(route('panel'));
    }

    /**
     * Cierra la sesión activa del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}