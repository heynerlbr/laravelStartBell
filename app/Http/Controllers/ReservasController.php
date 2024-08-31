<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasController extends Controller
{
    <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservas;

class ElementosLugaresController extends Controller
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
            $reservas =  reservas::get();
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success","reservas"=>$reservas]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error","reservas"=>$reservas]; 
        }
        return json_encode($mensaje);       
    }


    public function Eliminar(){
        $datos=json_decode($_POST['data']);
        try{
            $flight = reservas::find($datos->id);
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
            $role = reservas::create([
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
        $role="";
        try{
               $role=reservas::find($datos->id);                      
               $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","role"=>$role]; 
           }catch(\Exception $e){
               $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error","role"=>$role]; 
           }
        return json_encode($mensaje);
    }

    public function Actualizar(){
        $datos=json_decode($_POST['data']);
        try{
                $role=reservas::find($datos->id);  
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
}

}
