<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\lugares;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class LugaresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lugares.index');
    }
    public function Listar() {
        $lugares="";
        $municipios="";
        $empresas="";
        try{
            // $lugares =  lugares::get();
            $role = Auth::user()->roles->first()->name;

            // dd($role);
            
            $id_usuario_crea = Auth::user()->id;
            $id_empresa = Auth::user()->idEmpresa;
            // dd($id_empresa);

            if ($role=='admin') {
            $lugares=DB::table('lugares')
                    ->selectRaw('lugares.*,municipios.municipio,departamentos.departamento ,empresas_sistemas.nombre as nomEmpresa')
                    ->leftJoin('municipios', 'municipios.id_municipio', '=', 'lugares.IdMunicipio')
                    ->leftJoin('departamentos', 'departamentos.id_departamento', '=', 'municipios.departamento_id')
                    ->leftJoin('empresas_sistemas', 'empresas_sistemas.id', '=', 'lugares.idEmpresa')
                    ->get();
            }else{
                $lugares=DB::table('lugares')
                ->selectRaw('lugares.*,municipios.municipio,departamentos.departamento ,empresas_sistemas.nombre as nomEmpresa')
                ->leftJoin('municipios', 'municipios.id_municipio', '=', 'lugares.IdMunicipio')
                ->leftJoin('departamentos', 'departamentos.id_departamento', '=', 'municipios.departamento_id')
                ->leftJoin('empresas_sistemas', 'empresas_sistemas.id', '=', 'lugares.idEmpresa')
                ->where('lugares.id_usuario_crea','=',$id_usuario_crea)
                ->orWhere('lugares.id_empresa','=',$id_empresa)
                ->get();
            }

            $municipios=DB::table('municipios')
                    ->selectRaw('municipios.*, departamentos.departamento')
                    ->leftJoin('departamentos', 'departamentos.id_departamento', '=', 'municipios.departamento_id')
                    ->get();

            
            $queryEmpresa=DB::table('empresas_sistemas');

            switch ($role) {
                case 'admin':
                    break;
                    
                    default:
                    # code...
                    $queryEmpresa->where('id_empresa','=', $id_empresa);
                    break;
            }

            $empresas=$queryEmpresa->get();
                    

            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success",
            "lugares"=>$lugares,"municipios"=>$municipios,"empresas"=>$empresas]; 
        }catch(\Exception $e){
            // dd($e);
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error","lugares"=>$lugares,"municipios"=>$municipios,"empresas"=>$empresas]; 
        }
        return json_encode($mensaje);       
    }
    public function Eliminar(){
        $datos=json_decode($_POST['data']);
        try{
            $flight = lugares::find($datos->id);
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
            $id_usuario_crea = Auth::user()->id;
            $id_empresa = Auth::user()->idEmpresa;
            $role = lugares::create([
                'nombre' => $datos->nombre,
                'direccion'=>$datos->direccion,                
                'idEmpresa'=>$datos->idEmpresa,                
                'idMunicipio'=>$datos->idMunicipio,                
                'id_usuario_crea'=>$id_usuario_crea,                
                'id_empresa'=>$id_empresa,                
            ]);               
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }
    public function Mostrar(){
        $datos=json_decode($_POST['data']);
        $lugar="";
        try{
            $lugar=lugares::find($datos->id);                      
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","lugar"=>$lugar]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error","lugar"=>$lugar]; 
        }
        return json_encode($mensaje);
    }
    public function Actualizar(){
        $datos=json_decode($_POST['data']);
        try{
                $role=lugares::find($datos->id);  
                $role->nombre = $datos->nombre;
                $role->direccion=$datos->direccion;                
                $role->idEmpresa=$datos->idEmpresa;                
                $role->idMunicipio=$datos->idMunicipio;                       
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
