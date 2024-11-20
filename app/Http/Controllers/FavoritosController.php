<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\favoritos;
use Illuminate\Support\Facades\DB;

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
    try {
        $userId = $request->input('userId');

        // Realizando la consulta con DB
        $favoritos = DB::table('favoritos')
            ->join('lugares', 'favoritos.lugar_id', '=', 'lugares.id')
            ->where('favoritos.user_id', $userId)
            ->select('lugares.id as lugar_id', 'lugares.nombre', 'lugares.direccion')
            ->get();

        // Mapeo de resultados
        $favoritos = $favoritos->map(function ($favorito) {
            return [
                'id' => $favorito->lugar_id,
                'nombre' => $favorito->nombre,
                'direccion' => $favorito->direccion,
            ];
        });

        return response()->json([
            'success' => true,
            'favoritos' => $favoritos,
            'message' => 'Favoritos obtenidos exitosamente.',
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'No se pudo obtener la lista de favoritos. Inténtelo de nuevo más tarde.',
            'error' => $th->getMessage(),
        ], 500);
    }
}


    
}
