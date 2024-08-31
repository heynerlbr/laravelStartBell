<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function googleAuth(Request $request)
    {
        try {
            $token = $request->input('token');
            $googleUser = Socialite::driver('google')->userFromToken($token);

            // Buscar el usuario por su Google ID
            $user = User::where('google_id', $googleUser->id)->first();

            // Si el usuario no existe, créalo
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(str_random(24)), // Contraseña aleatoria
                ]);
            }

            // Generar un token de autenticación para la aplicación
            $authToken = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $authToken
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en la autenticación con Google',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ], 200);
    }
}
