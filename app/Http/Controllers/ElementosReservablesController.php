<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\elementos_lugares;
use App\Models\elementos_reservas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;


class ElementosReservablesController extends Controller
{
 

    public function index()
    {
        return view('reservas.index');
    }


    
    public function Listar() {
        $reservas="";
        try{
            $Tipouser = Auth::user()->roles->first()->name;
            $idUsuarioCrea = Auth::user()->id;
            if ($Tipouser=='admin') {

            }
            // $reservas =  elementos_reservas::get();
            $reservas = DB::table('elementos_reservas')
                        ->selectRaw('elementos_reservas.*,users.name')
                        ->leftJoin('elementos_lugares', 'elementos_lugares.id', '=', 'elementos_reservas.id_elemento')
                        ->leftJoin('users', 'users.id', '=', 'elementos_reservas.id_usuario_crea')
                        ->get(); 
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success","reservas"=>$reservas]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error","reservas"=>$reservas]; 
        }
        return json_encode($mensaje);       
    }


    public function Eliminar(){ 
        $datos=json_decode($_POST['data']);
        try{
            $flight = elementos_reservas::find($datos->id);
            $flight->delete();
            
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se eliminó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }


    public function crear(Request $request) {
        try {
            // Validación de entrada
            $validator = Validator::make($request->all(), [
                'fecha' => 'required|date',
                'id_elemento' => 'required|integer',
                'hora_inicio' => 'required',
                'hora_fin' => 'required',
                'id_usuario_crea' => 'required|integer',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'titulo' => 'Error de validación',
                    'respuesta' => $validator->errors(),
                    'tipo' => 'error'
                ], 422); // Código de estado HTTP 422 para datos no válidos
            }
    

            $horaInicio = Carbon::createFromFormat('g:i A', $request->input('hora_inicio'));
            $horaFin = Carbon::createFromFormat('g:i A', $request->input('hora_fin'));
    
            // Crear el registro
            // $reserva = elementos_reservas::create($request->all());

            elementos_reservas::create([
                'fecha' => $request->input('fecha'),
                'id_elemento' => $request->input('id_elemento'),
                'hora_inicio' => $horaInicio->format('H:i:s'), // Formato para tiempo en MySQL
                'hora_fin' => $horaFin->format('H:i:s'), // Formato para tiempo en MySQL
                'id_usuario_crea' => $request->input('id_usuario_crea'),
            ]);
    
            return response()->json([
                'titulo' => 'Éxito',
                'respuesta' => 'Se creó el registro correctamente',
                'tipo' => 'success'
            ], 201); // Código de estado HTTP 201 para creación exitosa
        } catch(QueryException $e) {
            // Manejar excepción de consulta de base de datos
            return response()->json([
                'titulo' => 'Error de base de datos',
                'respuesta' => 'No se pudo crear el registro debido a un error en la base de datos',
                'tipo' => 'error'
            ], 500); // Código de estado HTTP 500 para error interno del servidor
        } catch(\Exception $e) {
            // Capturar otras excepciones
            return response()->json([
                'titulo' => 'Error',
                'respuesta' => 'Ocurrió un error inesperado',
                'tipo' => 'error'
            ], 500); // Código de estado HTTP 500 para error interno del servidor
        }
    }
    

    
    public function Mostrar(){
        $datos=json_decode($_POST['data']);
        $role="";
        try{
            $role=elementos_reservas::find($datos->id);                      
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","role"=>$role]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error","role"=>$role]; 
        }
        return json_encode($mensaje);
    }

    public function Actualizar(){
        $datos=json_decode($_POST['data']);
        try{
                $role=elementos_reservas::find($datos->id);  
                $role->name=$datos->name; 
                $role->description=$datos->descripcion;                            
                $role->save();             
                $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se actualizó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se actualizó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
        //para imprimir de en la consola en network
        //dd($datos); 
    }


    //apis
    public function validarDiaApi(Request $request)
    {
        try {
            // Obtener la fecha enviada en el request
            $fecha = $request->input('fecha');
           
            $id_elemento = $request->input('id_elemento');
    
            // Obtener el día de la semana de la fecha enviada
            $diaSemana = date('N', strtotime($fecha));
    
            // Obtener los registros de la base de datos
            $elementoLugar = DB::table('elementos_lugares')
                            ->where('id','=',$id_elemento)
                            ->first();
    
            if ($elementoLugar) {
                $horariosReservados = []; // Array para almacenar los horarios reservados
    
                // Obtener reservas para el elemento en la fecha específica
                $reservas = DB::table('elementos_reservas')
                            ->where('id_elemento', $id_elemento)
                            ->where('fecha','=',$fecha)
                            ->get();
    
                // Recorrer las reservas y agregar los horarios reservados al array
                foreach ($reservas as $reserva) {
                    $horariosReservados[] = [
                        'inicio' => $reserva->hora_inicio,
                        'fin' => $reserva->hora_fin
                    ];
                }    
    
                // $horaApertura=$elementoLugar->hora_inicio_disponibilidad;
                // $horaCierre=$elementoLugar->hora_fin_disponibilidad;

                $horaApertura = substr($elementoLugar->hora_inicio_disponibilidad, 0, 5);
                $horaCierre = substr($elementoLugar->hora_fin_disponibilidad, 0, 5);
                // Convertir horas a objetos Carbon para comparación
                $horaAperturaCarbon = Carbon::createFromFormat('H:i', $horaApertura);
                $horaCierreCarbon = Carbon::createFromFormat('H:i', $horaCierre);
                $horaLimite = Carbon::createFromFormat('H:i', '06:00');

                // Verificar si la hora de apertura es mayor a la hora de cierre
                if ($horaAperturaCarbon->greaterThan($horaCierreCarbon)) {
                    // Ajustar la hora de apertura a las 06:00 AM
                    $horaApertura = $horaLimite->format('H:i');
                }

                // Calcular los horarios disponibles restando los horarios reservados
                $horariosDisponibles = $this->calcularHorariosDisponibles($horaApertura, $horaCierre, $horariosReservados);
                // $horariosDisponibles = [];
                $lunes=$elementoLugar->lunes;
                $martes=$elementoLugar->martes;
                $miercoles=$elementoLugar->miercoles;
                $jueves=$elementoLugar->jueves;
                $viernes=$elementoLugar->viernes;
                $sabado=$elementoLugar->sabado;
                $domingo=$elementoLugar->domingo;
    
                $diaValido=false;
    
                switch ($diaSemana) {
                    case '1':
                        $diaValido=$lunes;
                    break;
                    case '2':
                        $diaValido=$martes;
                    break;
                    case '3':
                        $diaValido=$miercoles;
                    break;
                    case '4':
                        $diaValido=$jueves;
                    break;
                    case '5':
                        $diaValido=$viernes;
                    break;
                    case '6':
                        $diaValido=$sabado;
                    break;
                    case '7':
                        $diaValido=$domingo;
                    break;
                    
                    default:
                    $diaValido=false;
                    break;
                }
            }   
            // Devolver los resultados en formato JSON
            return response()->json(['diaValido'=>$diaValido,'horariosDisponibles'=>$horariosDisponibles]);
        } catch (\Exception $e) {
            // Manejar cualquier excepción lanzada durante el proceso
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde.'.$e]);
        }
    }
    
    // Método para calcular los horarios disponibles restando los horarios reservados
    private function calcularHorariosDisponibles($horaApertura, $horaCierre, $horariosReservados)
    {
        $horariosDisponibles = [];

        $horaAperturaArray = explode(':', $horaApertura);
        $horaCierreArray = explode(':', $horaCierre);

        // Verificar y corregir si la hora o los minutos son "NaN"
        if ($horaAperturaArray[0] === 'NaN' || $horaAperturaArray[1] === 'NaN') {
            $horaApertura = '00:00';
        } else {
            $horaApertura = $horaAperturaArray[0] . ':' . $horaAperturaArray[1];
        }

        if ($horaCierreArray[0] === 'NaN' || $horaCierreArray[1] === 'NaN') {
            $horaCierre = '00:00';
        } else {
            $horaCierre = $horaCierreArray[0] . ':' . $horaCierreArray[1];
        }

    
        // Convertir las horas de apertura y cierre a objetos Carbon para facilitar la manipulación
        $apertura = Carbon::createFromFormat('H:i', $horaApertura);
        $cierre = Carbon::createFromFormat('H:i', $horaCierre);
    
        // Generar horarios disponibles en intervalos de 1 hora
        $horaActual = $apertura->copy();
        while ($horaActual->lte($cierre)) {
            $horaInicio = $horaActual->copy();
            $horaFin = $horaActual->addHour();
    
            // Verificar si el horario está disponible (no está reservado)
            $disponible = true;
            foreach ($horariosReservados as $reservado) {
                if ($horaInicio->between(
                    Carbon::createFromFormat('H:i', $reservado['inicio']),
                    Carbon::createFromFormat('H:i', $reservado['fin']),
                    true
                ) || $horaFin->between(
                    Carbon::createFromFormat('H:i', $reservado['inicio']),
                    Carbon::createFromFormat('H:i', $reservado['fin']),
                    true
                )) {
                    $disponible = false;
                    break;
                }
            }
    
            // Si el horario está disponible, agregarlo al array de horarios disponibles
            if ($disponible) {
                $horariosDisponibles[] = [
                    'inicio' => $horaInicio->format('H:i'),
                    'fin' => $horaFin->format('H:i')
                ];
            }
        }
    
        return $horariosDisponibles;
    }
    
}
