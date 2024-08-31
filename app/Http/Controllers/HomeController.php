<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\DB;
use DateTime;
use Jenssegers\Agent\Facades\Agent;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $Tipouser = Auth::user()->roles->first()->name;



        if (Agent::isDesktop()) {
            if ($Tipouser=='admin' || $Tipouser=='superadministrador' || $Tipouser=='administrador' || $Tipouser=='observador' ) {  
                return view('dashboard.index');
            }elseif ($Tipouser=='Conductor') {           
                
                return view('inicio.conductor');
            }else{
                return view('inicio.conductor');
            }
        } elseif (Agent::isMobile()) {
            if ($Tipouser=='admin' || $Tipouser=='superadministrador' || $Tipouser=='administrador' || $Tipouser=='observador') {  
                return view('inicio.conductor');
            }elseif ($Tipouser=='Conductor') {           
                
                return view('inicio.conductor');
            }else{
                return view('inicio.conductor');
            }
        } elseif (Agent::isTablet()) {
            if ($Tipouser=='admin' || $Tipouser=='superadministrador' || $Tipouser=='administrador' || $Tipouser=='observador') {  
                return view('inicio.conductor');
            }elseif ($Tipouser=='Conductor') {           
                
                return view('inicio.conductor');
            }else{
                return view('inicio.conductor');
            }
        }


        // dd( $Tipouser);
        if ($Tipouser=='admin') {  
            return view('dashboard.index');
        }elseif ($Tipouser=='Conductor') {           
            
            return view('inicio.conductor');
        }
        
        elseif ($Tipouser=='proveedor' || $Tipouser=='proveedorObservador' ) { 
            $RespuestaVencimiento='';
            $fecha_actual = strtotime(date("Y-m-d"));
            $fecha_now = date("Y-m-d");
            $user=User::find(Auth::user()->id);
            $fecha=$user->fechaVencimientoMembresia;
            $correoHas=$user->email;
            if ($fecha!=null && $fecha!="" && $fecha!="undefined") {
                $today = date('Y-m-d');
                $date1=date_create($today);              
                $date2=date_create($fecha);
                $diff=date_diff($date1,$date2);
                $timeDiff = $diff->format("%R%a");
                $timeDiff2 = $diff->format("%a");
                
                if($timeDiff < 0){
                   
                    $RespuestaVencimiento='VENCIDA';
                }else{                  
                    $RespuestaVencimiento='ACTIVA';
                }
                $days=$timeDiff2;
              if ($RespuestaVencimiento=='VENCIDA') {
                     $idUser=Auth::user()->id;
                     DB::table('role_user')
                     ->where('user_id', $idUser)
                     ->update(['role_id' => 8]);
                }else {
                    $idUser=Auth::user()->id;
                     DB::table('role_user')
                     ->where('user_id', $idUser)
                     ->update(['role_id' => 3]);
                }    
              $data=compact('RespuestaVencimiento','days','Tipouser','correoHas','days','fecha','today');         
            }else {
                $data=compact('RespuestaVencimiento');
            }
            return view('dashboard.index', $data);   
        } else {
            return redirect('/dashboard');    
        }     
    }
    public function perfil() {
        $Tipouser = Auth::user()->roles->first()->name;       
        return view('perfiles.index');       
    }
    public function MostrarInformacionPerfil()
    {
        try {
           $usuario = Auth::user();   
           $mensaje = ["Titulo" => "Éxito", "Respuesta" => "Mostrar Informacion Perfil", "Tipo" => "success","usuario" => $usuario];
        } catch (\Throwable $th) {
            $mensaje = ["Titulo" => "Error", "Respuesta" => "Mostrar Informacion Perfil", "Tipo" => "error"];
        }
        return json_encode($mensaje);       
    }
    public function updatePassword(Request $request)
    {      
        $data = json_decode($_POST['data']);
        if(!\Hash::check($data->old_password, auth()->user()->password)){
            $mensaje = ["Titulo" => "Error", "Respuesta" => "Ha ingresado una contraseña actual incorrecta", "Tipo" => "error"];
        }else{
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($data->new_password);
            $user->bpass = $data->new_password;
            if ($user->save()) {             
                $mensaje = ["Titulo" => "Éxito", "Respuesta" => "Se cambió la contraseña de manera correcta", "Tipo" => "success"];
            }
        }
        return json_encode($mensaje);
    }
    public function actualizarDatosPersonales()
    {
        try {
            $data = json_decode($_POST['data']);
            $user = User::find(Auth::user()->id);
            $user->name=$data->name;
            $user->celular=$data->celular;
            $user->save();
            $mensaje = ["Titulo" => "Éxito", "Respuesta" => "Se actualizó de manera correcta la información", "Tipo" => "success"];
        } catch (\Throwable $th) {
            $mensaje = ["Titulo" => "Error", "Respuesta" => "No se actualizó de manera correcta la información", "Tipo" => "error"];
        }
        return json_encode($mensaje);
    }
    public function actualizarCorreoFacturacion()
    {
        try {
            $data = json_decode($_POST['data']);
            $user = User::find(Auth::user()->id);
            $user->correoFacturacion=$data->correoFacturacion;
            $user->save();
            $mensaje = ["Titulo" => "Éxito", "Respuesta" => "Se actualizó el correo de facturación de manera correcta", "Tipo" => "success"];
        } catch (\Throwable $th) {
            $mensaje = ["Titulo" => "Error", "Respuesta" => "No se actualizó el correo de facturación de manera correcta", "Tipo" => "error"];
        }
        return json_encode($mensaje);
    }

    public function hojasvidas()  {
        return view('hojasvidas.index');   
    } 
   
    public function capacitaciones()  {
        return view('capacitaciones.index');   
    }
    public function vistaConductor()  {
        return view('inicio.conductor');   
    }


    // public function GuardarFilePerfil(Request $request)
    // {
    //     $Tipouser = Auth::user()->roles->first()->name;
    //     $idUsuario = Auth::user()->id;
    //     $compPic1 = "";
    //     $request = Request::capture(); // Captura la instancia de la solicitud actual
    //     $host = $request->getHost();
    //     $hostWithProtocol = $request->getSchemeAndHttpHost();

    //     try {
    //         $string = $request->data;
    //         $datos = json_decode($string);

    //         if ($datos->accion == 'nuevo') {
    //         //tomar toda la informacion
    //             if ($request->hasFile('filePerfil')) {
    //                 $nombreCompletoArchvio = $request->file('filePerfil')->getClientOriginalName();
    //                 $nombreDelArchivo = pathinfo($nombreCompletoArchvio, \PATHINFO_FILENAME);
    //                 $nombreDelArchivo= $this->quitarAcentos($nombreDelArchivo);
    //                 $extension = $request->file('filePerfil')->getClientOriginalExtension();
    //                 $compPic1 = str_replace(' ', '_', $nombreDelArchivo) . '-' . rand() . '_' . time() . '.' . $extension;
    //                 $path = $request->file('filePerfil')->storeAs('documentos', $compPic1);
    //             }
    //         }

    //         if ($datos->accion != 'nuevo') {
            
    //             $imageData=$datos->info;
    //             if ($imageData!='' && $imageData!=null ) {
    //                 $compPic1= HomeController::base64ToImage($imageData);
    //             }
    //         }

    //         $usuarios=User::find($idUsuario);
    //         if ($compPic1 != "") {
    //             $usuarios->imgUser = 'storage/documentos/' . $compPic1;
    //             $usuarios->save();
    //         }
            
    //         $mensaje = ["Titulo" => "Éxito", "Respuesta" => "Se guardo la imagen de manera correcta", "Tipo" => "success"];
            
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         $mensaje = ["Titulo" => "Error", "Respuesta" => "no se cambio el estado a facturado de manera correcta", "Tipo" => "error"];
    //     }
    //     return json_encode($mensaje);
    // }

    // public function base64ToImage($imageData) {   
    //     $extension='jpg';
    //     $base64_str = substr($imageData, strpos($imageData, ",")+1);       
    //     $fileName = uniqid().'.'.$extension;
    //     $imageData = base64_decode($base64_str);      
    //     Storage::disk('imagenes')->put($fileName, $imageData);
    //     return $fileName;
    // }

    // public function quitarAcentos($texto) {
    //     $acentos = [
    //         'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
    //         'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
    //         'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
    //         'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U',
    //         'ñ' => 'n', 'Ñ' => 'N',
    //     ];
    //     return strtr($texto, $acentos);
    // }

    public function GuardarFilePerfil(Request $request)
{
    $idUsuario = Auth::user()->id;
    $compPic1 = "";

    try {
        $string = $request->data;
        $datos = json_decode($string);

        if ($datos->accion == 'nuevo' && $request->hasFile('filePerfil')) {
            $file = $request->file('filePerfil');
            $compPic1 = $this->generateFileName($file);
            $file->storeAs('public/imagenesPerfil', $compPic1);
        } elseif ($datos->accion != 'nuevo' && !empty($datos->info)) {
            $compPic1 = $this->base64ToImage($datos->info);
        }

        $usuarios = User::find($idUsuario);
        if ($compPic1 != "") {
            $usuarios->imgUser = 'storage/imagenesPerfil/' . $compPic1;
            $usuarios->save();
        }

        $mensaje = ["Titulo" => "Éxito", "Respuesta" => "Se guardó la imagen de manera correcta", "Tipo" => "success"];

    } catch (\Throwable $th) {
        $mensaje = ["Titulo" => "Error", "Respuesta" => "No se cambió el estado a facturado de manera correcta", "Tipo" => "error"];
    }

    return json_encode($mensaje);
}

private function generateFileName($file)
{
    $nombreDelArchivo = pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME);
    $nombreDelArchivo = str_replace(' ', '_', $this->quitarAcentos($nombreDelArchivo));
    $extension = $file->getClientOriginalExtension();
    return $nombreDelArchivo . '-' . rand() . '_' . time() . '.' . $extension;
}

public function base64ToImage($imageData)
{
    $extension = 'jpg';
    $base64_str = substr($imageData, strpos($imageData, ",") + 1);
    $fileName = uniqid() . '.' . $extension;
    $imageData = base64_decode($base64_str);
    Storage::disk('imagenes')->put($fileName, $imageData);
    return $fileName;
}

public function quitarAcentos($texto)
{
    $acentos = ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u', 'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U', 'ñ' => 'n', 'Ñ' => 'N'];
    return strtr($texto, $acentos);
}

    

}
