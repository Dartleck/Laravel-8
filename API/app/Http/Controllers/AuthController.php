<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Buscar el usuario por correo electrónico
        $user = User::where('email', $request->email)->first();

        // Verificar que el usuario existe y la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Crear un token simple (esto es solo para demostración)
        $token = 'fake-jwt-token'; // Esto sería reemplazado por un token JWT real

        return response()->json(['token' => $token]);
    }
}
