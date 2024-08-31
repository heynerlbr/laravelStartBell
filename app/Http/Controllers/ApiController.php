<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\elementos_lugares;
use App\Models\elementos_imagenes;
use App\Models\lugares;
class ApiController extends Controller
{
    public function getMunicipios(Request $request) {
        try {
             // Obtener el departamento_id de los parámetros de la solicitud
            $departamento_id = $request->input('departamento_id');
            $municipios = DB::table('municipios')
                ->distinct()
                ->leftJoin('departamentos', 'departamentos.id_departamento', '=', 'municipios.departamento_id')
                ->selectRaw('municipios.*, departamentos.departamento')
                //  ->limit(300)
                ->where('departamento_id', $departamento_id)
               
                ->get();
    
            
             // Eliminar cualquier espacio en blanco o caracteres no deseados al principio y al final de la cadena JSON
            // $municipiosJson = json_encode(['municipios' => $municipios]);
            // $municipiosJson = preg_replace('/^\s+|\s+$/m', '', $municipiosJson);


            return response()->json(['municipios'=>$municipios]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al recuperar los municipios: ' . $th->getMessage(),
            ], 500); // Código de estado 500 para indicar un error interno del servidor
        }
    }


    public function getDepartamentos() {
        try {
            $departamentos = DB::table('departamentos')
                ->distinct()               
                ->selectRaw('departamentos.*')
                ->get();   
            return response()->json(['departamentos'=>$departamentos]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al recuperar los municipios: ' . $th->getMessage(),
            ], 500); // Código de estado 500 para indicar un error interno del servidor
        }
    }


    public function buscarMunicipios(Request $request) {
        try {
            // Obtener el texto de búsqueda de los parámetros de la solicitud
            $textoBusqueda = $request->input('textoBusqueda');
    
            // Realizar la búsqueda de municipios que coincidan con el texto de búsqueda
            $municipios = DB::table('municipios')
                ->distinct()
                ->leftJoin('departamentos', 'departamentos.id_departamento', '=', 'municipios.departamento_id')
                ->selectRaw('municipios.*, departamentos.departamento')
                ->where('municipios.municipio', 'LIKE', '%' . $textoBusqueda . '%')
                ->get();
    
            // Devolver los municipios encontrados como respuesta
            return response()->json(['municipios' => $municipios]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al recuperar los municipios: ' . $th->getMessage(),
            ], 500); // Código de estado 500 para indicar un error interno del servidor
        }
    }

    public function buscarTiposResevas(Request $request) {
        try {
            // Obtener el texto de búsqueda de los parámetros de la solicitud
            $textoBusqueda = $request->input('textoBusqueda');
    
            // Realizar la búsqueda de municipios que coincidan con el texto de búsqueda
            $reservas = DB::table('reservables')
                ->distinct()
             
                ->where('reservables.nombre', 'LIKE', '%' . $textoBusqueda . '%')
                ->get();
    
            // Devolver los municipios encontrados como respuesta
            return response()->json(['reservas' => $reservas]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al recuperar los reservas: ' . $th->getMessage(),
            ], 500); // Código de estado 500 para indicar un error interno del servidor
        }
    }


    public function obtenerlugaresFiltrados(Request $request) {
        try {
            // Obtener el texto de búsqueda de los parámetros de la solicitud
            $idMunicipio = $request->input('idMunicipio');
            $idTipoReserva = $request->input('idTipoReserva');
    
            // // Realizar la búsqueda de municipios que coincidan con el texto de búsqueda
            $lugaresFiltrados = DB::table('lugares')
                ->distinct()
                ->select('lugares.*')
                ->leftJoin('elementos_lugares', 'elementos_lugares.id_lugar', '=', 'lugares.id')
                ->leftJoin('municipios', 'municipios.id_municipio', '=', 'lugares.idMunicipio')
                ->where('lugares.idMunicipio','=',$idMunicipio)
                ->where('elementos_lugares.id_reservable','=',$idTipoReserva)
                ->get()->toArray();
    
         

        // Devolver los lugares filtrados como respuesta
        return response()->json(['lugaresFiltrados' => $lugaresFiltrados]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al recuperar los lugaresFiltadros: ' . $th->getMessage(),
            ], 500); // Código de estado 500 para indicar un error interno del servidor
        }
    }

    


    public function obtenerElementosFiltrados(Request $request) {
        try {
            // Obtener los parámetros de la solicitud
            $idMunicipio = $request->input('idMunicipio');
            $idTipoReserva = $request->input('idTipoReserva');
            $idLugar = $request->input('idLugar');
    
            // Realizar la búsqueda de elementos filtrados
            $elementosFiltrados = DB::table('elementos_lugares')
                ->distinct()
                ->leftJoin('lugares', 'elementos_lugares.id_lugar', '=', 'lugares.id')

                ->select('elementos_lugares.*')
                ->where('lugares.idMunicipio', $idMunicipio)
                ->where('elementos_lugares.id_reservable', $idTipoReserva)
                ->where('elementos_lugares.id_lugar', $idLugar)
                ->get();
    
            // Devolver los elementos filtrados como respuesta
            return response()->json(['elementosFiltrados' => $elementosFiltrados]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al recuperar los elementos filtrados: ' . $th->getMessage(),
            ], 500);
        }
    }


    public function obtenerInformacionElemento(Request $request) {
        try {
            // Obtener los parámetros de la solicitud
            $idElemento = $request->input('id');

            $elemento = DB::table('elementos_lugares')
                ->distinct()
                ->selectRaw('elementos_lugares.*')
                ->leftJoin('lugares', 'elementos_lugares.id_lugar', '=', 'lugares.id')
                ->where('elementos_lugares.id', $idElemento)
                ->first();

            $imagenes=DB::table('elementos_imagenes')
                    ->where('id_elemento','=',$idElemento)
                    ->get()
                    ->toArray();            
    
            // Devolver los elementos filtrados como respuesta
            return response()->json(['elemento' => $elemento,"imagenes"=>$imagenes]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al recuperar el elemento: ' . $th->getMessage(),
            ], 500);
        }
    }

}
