<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Método para iniciar sesión y generar token
    public function login(Request $request)
{
    // Validar los datos recibidos
    \Log::info('Intentando iniciar sesión con: ', ['email' => $request->email]);
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Buscar el usuario por correo electrónico
    $user = User::where('email', $request->email)->first();

    // Verificar que el usuario existe y la contraseña es correcta
    if (!$user || !Hash::check($request->password, $user->password)) {
        \Log::error('Credenciales inválidas');
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas son incorrectas.'],
        ]);
    }

    // Crear un token real con Sanctum
    \Log::info('Generando token para: ', ['email' => $request->email]);
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}


    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Crear un token tras el registro
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
        
    }

    // Método para cerrar sesión y revocar los tokens
    public function logout(Request $request)
    {
        // Eliminar todos los tokens del usuario autenticado
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }
}
