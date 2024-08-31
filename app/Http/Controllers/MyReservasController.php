<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\elementos_reservas;
use Illuminate\Http\Request;

class MyReservasController extends Controller
{
    function Listar(Request $request)  {
        $reservas=[];
        try {
            $idUsuario = $request->input('id');

            $reservas = DB::table('elementos_reservas')
                        ->selectRaw('elementos_reservas.*,users.name,lugares.nombre as nombreLugar,lugares.direccion as direccionLugar,municipios.municipio,departamentos.departamento')
                        ->leftJoin('elementos_lugares', 'elementos_lugares.id', '=', 'elementos_reservas.id_elemento')
                        ->leftJoin('lugares', 'lugares.id', '=', 'elementos_lugares.id_lugar')
                        ->leftJoin('municipios', 'municipios.id_municipio', '=', 'lugares.IdMunicipio')
                        ->leftJoin('departamentos', 'departamentos.id_departamento', '=', 'municipios.departamento_id')
                        ->leftJoin('users', 'users.id', '=', 'elementos_reservas.id_usuario_crea')
                        ->where('elementos_reservas.id_usuario_crea','=',$idUsuario)
                        ->where('elementos_reservas.estado','<>',0)
                        ->get(); 

            return response()->json(['Titulo'=>'Exitó','Tipo'=>'success','Respuesta'=>'se lista de manera correcta','reservas'=> $reservas]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.'.$th]);
        }
    }

    function CancelarReservaApi(Request $request)  {
       
        try {
            $id = $request->input('id');

            $reserva =elementos_reservas::find($id);
            $reserva->estado=0;
            $reserva->save();

            return response()->json(['Titulo'=>'Exitó','Tipo'=>'success','Respuesta'=>'se lista de manera correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.'.$th]);
        }
    }




}