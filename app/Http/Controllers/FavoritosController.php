<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\favoritos;

class FavoritosController extends Controller
{
    public function agregarAFavoritos(Request $request)
{
    try {
        $userId = $request->input('userId');
        $lugarId = $request->input('lugarId');


        // return response()->json(['success' => false, 'message' => 'UserId y LugarId son requeridos'], 400);

        if (!$userId || !$lugarId) {
            return response()->json(['success' => false, 'message' => 'UserId y LugarId son requeridos'], 400);
        }

        $favorito = favoritos::where('user_id', $userId)
                             ->where('lugar_id', $lugarId)
                             ->first();

        if ($favorito) {
            $favorito->delete();
            $message = 'Eliminado de favoritos';
        } else {
            favoritos::create([
                'user_id' => $userId,
                'lugar_id' => $lugarId,
            ]);
            $message = 'Agregado a favoritos';
        }

        return response()->json(['success' => true, 'message' => $message]);
    } catch (\Exception $e) {
        // \Log::error('Error en toggleFavorito: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error interno del servidor'.$e->getMessage()], 500);
    }
}

    public function obtenerFavoritos(Request $request)
    {
        $userId = $request->input('userId');
        
        $favoritos = favoritos::where('user_id', $userId)
                            ->with('lugar') // Relación con el modelo Lugar
                            ->get()
                            ->map(function($favorito) {
                                return [
                                    'id' => $favorito->lugar->id,
                                    'nombre' => $favorito->lugar->nombre,
                                    'direccion' => $favorito->lugar->direccion,
                                ];
                            });

        return response()->json([
            'success' => true,
            'favoritos' => $favoritos,
        ]);
    }

    
}
