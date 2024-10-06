<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\elementos_reservas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reservas.index');
    }


    
    public function Listar() {
        $reservas="";
        try{

            $role = Auth::user()->roles->first()->name;
            $id_usuario_crea = Auth::user()->id;
            $id_empresa = Auth::user()->idEmpresa;

            if ($role=='admin') {
                $reservas =  DB::table('elementos_reservas') 
                            ->selectRaw('elementos_reservas.*,lugares.nombre as nombreLugar,elementos_lugares.nombre as nombreElemento')               
                            ->leftjoin('elementos_lugares','elementos_lugares.id','=','elementos_reservas.id_elemento')
                            ->leftjoin('lugares','lugares.id','=','elementos_lugares.id_lugar')
                            ->get();
            }else{
                $reservas =  DB::table('elementos_reservas')       
                            ->selectRaw('elementos_reservas.*,lugares.nombre as nombreLugar,elementos_lugares.nombre as nombreElemento')           
                            ->leftjoin('elementos_lugares','elementos_lugares.id','=','elementos_reservas.id_elemento')
                            ->leftjoin('lugares','lugares.id','=','elementos_lugares.id_lugar')
                            ->where('lugares.id_usuario_crea','=', $id_usuario_crea)
                            ->where('lugares.id_empresa','=', $id_empresa)
                            ->get();
            }
            
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success","reservas"=>$reservas]; 
        }catch(\Exception $e){
            // dd($e);
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


    public function Crear(){
        $datos=json_decode($_POST['data']);
        try{         
            $role = elementos_reservas::create([
                'name' => $datos->name,
                'description'=>$datos->descripcion                
            ]);                      
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }

    
    public function Mostrar(){
        $datos=json_decode($_POST['data']);
        $reserva="";
        try{
            // $reserva=elementos_reservas::find($datos->id);   
            $reserva = DB::table('elementos_reservas')       
                    ->selectRaw('elementos_reservas.*, lugares.nombre as nombreLugar, elementos_lugares.nombre as nombreElemento')           
                    ->leftJoin('elementos_lugares', 'elementos_lugares.id', '=', 'elementos_reservas.id_elemento')
                    ->leftJoin('lugares', 'lugares.id', '=', 'elementos_lugares.id_lugar')
                    ->where('elementos_reservas.id', '=', $datos->id)
                    ->first();                   
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","reserva"=>$reserva]; 
        }catch(\Exception $e){
        $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error","reserva"=>$reserva]; 
        }
        return json_encode($mensaje);
    }

    public function Actualizar(){
        $datos=json_decode($_POST['data']);
        try{
                $reserva=elementos_reservas::find($datos->id); 
                $reserva->fecha=$datos->fecha;
                $reserva->hora_inicio=$datos->hora_inicio;
                $reserva->hora_fin=$datos->hora_fin;
                $reserva->save();             
                $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se actualizó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se actualizó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
        //para imprimir de en la consola en network
        //dd($datos); 
    }
}
