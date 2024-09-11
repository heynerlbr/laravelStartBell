<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\elementos_lugares;
use App\Models\elementos_imagenes;
use App\Models\elementos_reservas;
use App\Models\lugares;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ElementosLugaresController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('elementos_lugares.index');
    }
    public function Listar() {
        $elementos_lugares="";
        $lugares="";
        $lugaresTabla="";
        $reservables=[];
        try{

            
            $role = Auth::user()->roles->first()->name;
            $id_usuario_crea = Auth::user()->id;

            if ($role=='admin') {
                $lugares=DB::table('lugares')->get();
                $lugaresTabla=DB::table('lugares')->get();
                $elementos_lugares =  elementos_lugares::get();
            }else{
                $lugares=DB::table('lugares')
                        ->where('id_usuario_crea','=',$id_usuario_crea)
                        ->get();
                $lugaresTabla=DB::table('lugares')
                                ->where('id_usuario_crea','=',$id_usuario_crea)
                            ->get();
                // $elementos_lugares =  elementos_lugares::get();
                $elementos_lugares = DB::table('elementos_lugares')
                                    ->select('elementos_lugares.*')
                                    ->leftjoin('lugares','lugares.id','=','elementos_lugares.id_lugar')
                                    ->where('lugares.id_usuario_crea','=',$id_usuario_crea)
                                    ->get();
            }



            $reservables=DB::table('reservables')->get();
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success",
            "elementos_lugares"=>$elementos_lugares,"lugares"=>$lugares,"lugaresTabla"=>$lugaresTabla,"reservables"=>$reservables]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error",
            "elementos_lugares"=>$elementos_lugares,"lugares"=>$lugares,"lugaresTabla"=>$lugaresTabla,"reservables"=>$reservables]; 
        }
        return json_encode($mensaje);       
    }
    public function Eliminar(){
        $datos=json_decode($_POST['data']);
        try{
            $flight = elementos_lugares::find($datos->id);
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
            $fecha_crea=date('Y-m-d');
            $id_usuario_crea = Auth::user()->id;    
            $role = elementos_lugares::create([      
                'id_lugar'=> $datos->id_lugar,
                'nombre'=> $datos->nombre,
                'numero_capacidad'=> $datos->numero_capacidad,
                'hora_inicio_disponibilidad'=> $datos->hora_inicio_disponibilidad,
                'hora_fin_disponibilidad'=> $datos->hora_fin_disponibilidad,
                'lunes'=> $datos->lunes,
                'martes'=> $datos->martes,
                'miercoles'=> $datos->miercoles,
                'jueves'=> $datos->jueves,
                'viernes'=> $datos->viernes,
                'sabado'=> $datos->sabado,
                'domingo'=> $datos->domingo,
                'descripcion'=> $datos->descripcion,
                'id_reservable'=> $datos->id_reservable,
                'fecha_crea'=>$fecha_crea,
                'valor'=>$datos->valor,
                'id_usuario_crea'=>$id_usuario_crea
            ]);              
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }
    public function Mostrar(){
        $datos=json_decode($_POST['data']);
        $elemento="";
        try{
            $elemento=elementos_lugares::find($datos->id);                      
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","elemento"=>$elemento]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error","elemento"=>$elemento]; 
        }
        return json_encode($mensaje);
    }
    public function Actualizar(){
        $datos=json_decode($_POST['data']);
        try{
            $fecha_modifica=date('Y-m-d');
            $role=elementos_lugares::find($datos->id);  
            $role->id_lugar= $datos->id_lugar;
            $role->nombre= $datos->nombre;
            $role->numero_capacidad= $datos->numero_capacidad;
            $role->hora_inicio_disponibilidad= $datos->hora_inicio_disponibilidad;
            $role->hora_fin_disponibilidad= $datos->hora_fin_disponibilidad;
            $role->lunes= $datos->lunes;
            $role->martes= $datos->martes;
            $role->miercoles= $datos->miercoles;
            $role->jueves= $datos->jueves;
            $role->viernes= $datos->viernes;
            $role->sabado= $datos->sabado;
            $role->domingo= $datos->domingo;
            $role->descripcion= $datos->descripcion;    
            $role->id_reservable= $datos->id_reservable;                  
            $role->fecha_modifica= $fecha_modifica;   
            $role->valor=$datos->valor;               
            $role->save();             
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se actualizó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se actualizó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
        //para imprimir de en la consola en network
        //dd($datos); 
    }
    public function  MostrarElementosLugares(){
        $datos=json_decode($_POST['data']);
        $lugaresElementos=[];
        try{
            $idLugar=$datos->idLugar;
            $lugaresElementos=DB::table('elementos_lugares')
                            ->where('id_lugar','=',$idLugar)
                            ->get()->toArray();
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se consultó  de manera correcta","Tipo"=>"success","lugaresElementos"=>$lugaresElementos]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se consultó el registro de manera correcta","Tipo"=>"error","lugaresElementos"=>$lugaresElementos]; 
        }
        return json_encode($mensaje);
    }
    public function  SubirImagenElemento(Request $request){
        $request = Request::capture(); // Captura la instancia de la solicitud actual
        $host = $request->getHost();
        $hostWithProtocol = $request->getSchemeAndHttpHost();
        // $urlbucket='https://ventanarfiles.s3.us-east-2.amazonaws.com/';
        $string = $request->data;
        $datos = json_decode($string);
        $IdUsuarioCrea = Auth::user()->id;
        $fecha=date('Y-m-d');
        try{
            if ($request->hasFile('fileDato')) {
                $nombreCompletoArchvio = $request->file('fileDato')->getClientOriginalName();
                //cargar archivo a amazon s3
                $file = $request->file('fileDato');
                // $paths3 = Storage::disk('s3')->put('uploads', $file, 'public');
                $nombreDelArchivo = pathinfo($nombreCompletoArchvio, \PATHINFO_FILENAME);
                $nombreDelArchivo= $this->quitarAcentos($nombreDelArchivo);
                $extension = $request->file('fileDato')->getClientOriginalExtension();
                $tamañoEnBytes = $file->getSize();
                $tamañoEnMegas = $tamañoEnBytes / 1048576;
                $compPic1 = str_replace(' ', '_', $nombreDelArchivo) . '-' . rand() . '_' . time() . '.' . $extension;
                $path = $request->file('fileDato')->storeAs('public/logos', $compPic1);
                $parteUrl= $hostWithProtocol.'/storage/logos/';
                $entidad = elementos_imagenes::create([
                    'nombre' => ucfirst(strtolower($nombreDelArchivo)),
                    'url' => $parteUrl.$compPic1,  
                    'extension'=>strtolower($extension),  
                    'tamano'=>$tamañoEnMegas,
                    'id_usuario' =>$IdUsuarioCrea,
                    'fecha_crea'=>$fecha,
                    'id_elemento'=> $datos->id,      
                ]); 
                $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se subió  de manera correcta","Tipo"=>"success"]; 
            }else{
                $mensaje = ["Titulo"=>"Alerta","Respuesta"=>"Por favor seleccione un archivo","Tipo"=>"info"]; 
            }
        }catch(\Exception $e){
            // dd($e);
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se consultó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }
    public function  ListarImagenesElemento(){
        $datos=json_decode($_POST['data']);
        $elementos_imagenes=[];
        try{
            $id=$datos->id;
            $elementos_imagenes=DB::table('elementos_imagenes')
                            ->where('id_elemento','=',$id)
                            ->get()->toArray();
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se consultó  de manera correcta","Tipo"=>"success","elementos_imagenes"=>$elementos_imagenes]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se consultó el registro de manera correcta","Tipo"=>"error","elementos_imagenes"=>$elementos_imagenes]; 
        }
        return json_encode($mensaje);
    }
    public function quitarAcentos($texto) {
        $acentos = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U',
            'ñ' => 'n', 'Ñ' => 'N',
        ];
        return strtr($texto, $acentos);
    }


    public function EliminarImagenElemento(){
        $datos=json_decode($_POST['data']);
        try{
            $flight = elementos_imagenes::find($datos->id);
            $flight->delete();
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se eliminó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }

    public function SeleccionarImagenPrincipal()  {
        $datos=json_decode($_POST['data']);
        try{



            $flight = elementos_imagenes::find($datos->id);
            $url=$flight->url;
            $id_elemento=$flight->id_elemento;
            elementos_imagenes::where('id_elemento', $id_elemento)->update(['imagen_principal' => 0]);
            $flight->imagen_principal=1;
            $flight->save();

            $registro=elementos_lugares::find($id_elemento);
            $registro->url_imagen=$url;
            $registro->save();

            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se eliminó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){

            // dd($e);
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }


    public function ListarReservasElemento() {
        $datos = json_decode($_POST['data']);
        try {
            $elementos_reservas = DB::table('elementos_reservas')
            ->where('id_elemento', $datos->id_elemento)
            ->get();

            // dd($elementos_reservas );
            $mensaje = [
                "Titulo" => "Éxito",
                "Respuesta" => "Elementos obtenidos correctamente.",
                "Tipo" => "success",
                'elementos_reservas' => $elementos_reservas
            ];
        } catch (\Throwable $th) {
            $mensaje = [
                "Titulo" => "Error",
                "Respuesta" => "Algo salió mal, contacte al administrador del sistema.",
                "Tipo" => "error"
            ];
        }
        return json_encode($mensaje);
    }
    public function CrearReservaElemento(Request $request) {
        $datos = json_decode($_POST['data']);
        try {
            $id_usuario=Auth::user()->id;
            $elemento_reserva = new elementos_reservas();
            $elemento_reserva->id_elemento = $datos->id_elemento;
            $elemento_reserva->fecha = $datos->fecha;
            $elemento_reserva->usuario = $id_usuario;
            // Asigna otros campos necesarios
            $elemento_reserva->save();
    
            $mensaje = [
                "Titulo" => "Éxito",
                "Respuesta" => "Reserva creada correctamente.",
                "Tipo" => "success",
                'elemento_reserva' => $elemento_reserva
            ];
        } catch (\Throwable $th) {
            $mensaje = [
                "Titulo" => "Error",
                "Respuesta" => "No se pudo crear la reserva, contacte al administrador.",
                "Tipo" => "error"
            ];
        }
        return json_encode($mensaje);
    }
    public function ObtenerReservaElemento() {
        try {
            $datos = json_decode($_POST['data']);
            $elemento_reserva = elementos_reservas::find($datos->id);
            if ($elemento_reserva) {
                $mensaje = [
                    "Titulo" => "Éxito",
                    "Respuesta" => "Reserva encontrada.",
                    "Tipo" => "success",
                    'elemento_reserva' => $elemento_reserva
                ];
            } else {
                $mensaje = [
                    "Titulo" => "Error",
                    "Respuesta" => "Reserva no encontrada.",
                    "Tipo" => "error"
                ];
            }
        } catch (\Throwable $th) {
            $mensaje = [
                "Titulo" => "Error",
                "Respuesta" => "Algo salió mal, contacte al administrador.",
                "Tipo" => "error"
            ];
        }
        return json_encode($mensaje);
    }
    public function ActualizarReservaElemento(Request $request) {
        $datos = json_decode($_POST['data']);
        try {
            $elemento_reserva = elementos_reservas::find($datos->id);
            if ($elemento_reserva) {
                $id_usuario=Auth::user()->id;
                $elemento_reserva->fecha = $datos->fecha ?? $elemento_reserva->fecha;
                $elemento_reserva->id_usuario_crea = $id_usuario ?? $elemento_reserva->usuario;
                // Actualiza otros campos necesarios
                $elemento_reserva->save();
    
                $mensaje = [
                    "Titulo" => "Éxito",
                    "Respuesta" => "Reserva actualizada correctamente.",
                    "Tipo" => "success",
                    'elemento_reserva' => $elemento_reserva
                ];
            } else {
                $mensaje = [
                    "Titulo" => "Error",
                    "Respuesta" => "Reserva no encontrada.",
                    "Tipo" => "error"
                ];
            }
        } catch (\Throwable $th) {
            $mensaje = [
                "Titulo" => "Error",
                "Respuesta" => "No se pudo actualizar la reserva, contacte al administrador.",
                "Tipo" => "error"
            ];
        }
        return json_encode($mensaje);
    }

    public function EliminarReservaElemento() {
        try {
            $datos = json_decode($_POST['data']);
            $elemento_reserva = elementos_reservas::find($datos->id);
            if ($elemento_reserva) {
                $elemento_reserva->delete();
                $mensaje = [
                    "Titulo" => "Éxito",
                    "Respuesta" => "Reserva eliminada correctamente.",
                    "Tipo" => "success"
                ];
            } else {
                $mensaje = [
                    "Titulo" => "Error",
                    "Respuesta" => "Reserva no encontrada.",
                    "Tipo" => "error"
                ];
            }
        } catch (\Throwable $th) {
            $mensaje = [
                "Titulo" => "Error",
                "Respuesta" => "No se pudo eliminar la reserva, contacte al administrador.",
                "Tipo" => "error"
            ];
        }
        return json_encode($mensaje);
    }
    

    public function CambiarEstadoReserva(Request $request) {
        $datos = json_decode($_POST['data']);
        try {
            $elemento_reserva = elementos_reservas::find($datos->id);
    
            if ($elemento_reserva) {
                // Cambiar el estado si está dentro de los valores permitidos (0, 1, 2)
                if (in_array(intval($datos->estado), [0, 1, 2])) {
                    $elemento_reserva->estado = $datos->estado;
                    $elemento_reserva->save();
    
                    $mensaje = [
                        "Titulo" => "Éxito",
                        "Respuesta" => "Estado actualizado correctamente.",
                        "Tipo" => "success",
                        'elemento_reserva' => $elemento_reserva
                    ];
                } else {
                    $mensaje = [
                        "Titulo" => "Error",
                        "Respuesta" => "El estado proporcionado no es válido.",
                        "Tipo" => "error"
                    ];
                }
            } else {
                $mensaje = [
                    "Titulo" => "Error",
                    "Respuesta" => "Reserva no encontrada.",
                    "Tipo" => "error"
                ];
            }
        } catch (\Throwable $th) {
            $mensaje = [
                "Titulo" => "Error",
                "Respuesta" => "Algo salió mal, contacte al administrador.",
                "Tipo" => "error"
            ];
        }
        return json_encode($mensaje);
    }
    
    
    
    
    
    


}
