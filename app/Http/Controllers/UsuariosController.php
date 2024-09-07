<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use  App\Models\User;
use  App\Models\Role;
use  App\Models\cargos;
use  App\Models\users_documentos;
use  App\Models\users_sucursales;
use  App\Models\tipo_documentos;
use  App\Models\empresas_sistemas;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Hash; 
class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.index');
    }
    public function Listar() {
        $nombreUsuario = Auth::user()->name;
        $Tipouser = Auth::user()->roles->first()->name;
        // dd($Tipouser);
        $IdUsuarioCrea = Auth::user()->id;
        $infoUsuario = Auth::user();
        $idEmpresa=$infoUsuario->idEmpresa;
        $idSucursal=$infoUsuario->id_sucursal;
        $usuarios="";
        $roles="";
        $zonas="";
        $sucursales="";
        $categorias=""; 
        $empresas_sistemas ="";
        $cargos = "";
        $tipo_documentos="";
        try{
            // $roles =  Role::get();
                $roles =  DB::table('roles')
                ->select('roles.*')
                // ->where('roles.id','<>','8')           
                ->get();
            // $usuarios =  User::get();
                $usuarios =  DB::table('users')
                            ->select('users.*')
                            // ->selectRaw('roles.description as descript', 'zonas.nombre as NomZonas')
                            ->join('role_user', 'users.id', '=', 'role_user.user_id')
                            // ->join('role_user', 'users.id_zonas', '=', 'zonas.id')
                            // ->leftJoin('cargos', 'cargos.id', '=', 'users.id_cargo')
                            ->join('roles', 'roles.id', '=', 'role_user.role_id')
                            ->get();


               

                // $zonas=DB::table('zonas')->get();
                // $sucursales=DB::table('sucursales')->get();
                // $categorias =  DB::table('categorias')->get();
                $empresas_sistemas =  DB::table('empresas_sistemas')->get();
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success","usuarios"=>$usuarios,"roles"=>$roles,"zonas"=>$zonas,
            "sucursales"=>$sucursales,"categorias"=>$categorias,"empresas_sistemas"=> $empresas_sistemas,"Tipouser"=>$Tipouser,"tipo_documentos"=>$tipo_documentos,"cargos"=>$cargos]; 
        }catch(\Exception $e){
             dd($e);
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error","usuarios"=>$usuarios,"roles"=>$roles,"zonas"=>$zonas,
            "sucursales"=>$sucursales,"categorias"=>$categorias,"empresas_sistemas"=> $empresas_sistemas,"Tipouser"=>$Tipouser]; 
        }
        return json_encode($mensaje);       
    }
    public function Eliminar(){
        $datos=json_decode($_POST['data']);
        try{
            $flight = User::find($datos->id);
              // Eliminar la relación en la tabla role_user
            $flight->roles()->detach();
            $flight->delete();
               $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se eliminó el registro de manera correcta","Tipo"=>"success"]; 
           }catch(\Exception $e){
               $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error"]; 
           }
           return json_encode($mensaje);
    }
    public function obtenerIdCreacionUsuario(){
        $timezone='America/Bogota';
        date_default_timezone_set($timezone);
        $nombreUsuario = Auth::user()->name;
        $Tipouser = Auth::user()->roles->first()->name;
        // if ($Tipouser == 'contratacion') {
        //     $IdUsuarioCrea = $datos -> idAsesor;
        // } else {
        //     # code...
        // }
        $IdUsuarioCrea = Auth::user()->id;
        $fecha = date("Y-m-d");
        $fechaTime = date("Y-m-d H:i:s");
        $idCreacion="";
        try {
            //obtener id de creacion
            $usuario=User::create([                
                'estado'=>'1',
            ]);
            $mensaje = ["Titulo"=>"Éxito","Respuesta"=>"Se actualizó el registro de manera correcta","Tipo"=>"success","idCreacion"=> $usuario->id];
        } catch (\Throwable $th) {
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contactese con el administrador del sistema","Tipo"=>"error"];
        }
        return json_encode($mensaje);
    }
    public function ListarDocumetosUsuarios() {
        $datos=json_decode($_POST['data']);
        $usuario="";
        $role="";
        $categorias="";
        $nombreUsuario = Auth::user()->name;
        $Tipouser = Auth::user()->roles->first()->name;
        $IdUsuarioCrea = Auth::user()->id;
        try{
            //    $users_documentos=User::users_documentos($datos->id);  
            //    $role=DB::table('role_user')
            //    ->select('role_id')
            //    ->where('user_id', $datos->id)
            //    ->get();
            //    dd($role);
            // $categorias =  DB::table('categorias')->get();
                // $users_documentos =  DB::table('users_documentos ')
                //     ->selectRaw('users_documentos.*')
                //     // ->whereNotNull('nombre') 
                //     ->where('id_usuario', $datos->id)
                //     ->get();
                $users_documentos = DB::table('users_documentos')
                ->select('users_documentos.*', 'tipo_documentos.nombre as nombre_documento')
                ->join('tipo_documentos', 'users_documentos.id_tipo_documento', '=', 'tipo_documentos.id')
                ->where('users_documentos.id_usuario', $datos->id)
                ->get();
               $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se listo de manera correcta","Tipo"=>"success","users_documentos"=>$users_documentos 
            ]; 
           }catch(\Exception $e){
               $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se listo de manera correcta","Tipo"=>"error"
            ]; 
           }
        return json_encode($mensaje);     
    }
    public function GuardarDocumentoUsuario(Request $request){
        try {
            $request = Request::capture(); // Captura la instancia de la solicitud actual
            $host = $request->getHost();
            $hostWithProtocol = $request->getSchemeAndHttpHost();
            // $urlbucket='https://ventanarfiles.s3.us-east-2.amazonaws.com/';
            $string = $request->data;
            $datos = json_decode($string);
            if ($request->hasFile('fileDato')) {
                // $registroEquipo=equipos::find($datos->id_equipo);
                $idUsuario=$datos->id_usuario;
                $nombreCompletoArchvio = $request->file('fileDato')->getClientOriginalName();
                //cargar archivo a amazon s3
                $file = $request->file('fileDato');
                // $paths3 = Storage::disk('s3')->put('uploads', $file, 'public');
                $nombreDelArchivo = pathinfo($nombreCompletoArchvio, \PATHINFO_FILENAME);
                // $nombreDelArchivo= $this->quitarAcentos($nombreDelArchivo);
                $nombreDelArchivo = $this->quitarAcentos($nombreDelArchivo);
                $extension = $request->file('fileDato')->getClientOriginalExtension();
                // dd($extension);
                $tamañoEnBytes = $file->getSize();
                $tamañoEnMegas = $tamañoEnBytes / 1048576;
                $compPic1 = str_replace(' ', '', $nombreDelArchivo) . '-' . rand() . '' . time() . '.' . $extension;
                $path = $request->file('fileDato')->storeAs('public/usurios/documentos/'.$idUsuario.'/papeles/', $compPic1);
                $parteUrl= $hostWithProtocol.'/storage/usurios/documentos/'.$idUsuario.'/papeles/';
                if (!isset($datos->fecha)) {
                    $datos->fecha=null;
                }
                $IdUsuarioCrea = Auth::user()->id;
                $fecha = date("Y-m-d");
                $resultados = DB::table('tipo_documentos as td1')
                ->select('td1.nombre')
                ->leftJoin('tipo_documentos as td2', 'td1.id', '=', 'td2.id')
                ->where('td1.id', $datos->id_tipo_documento)
                ->get();
                // dd($resultados); 
                users_documentos::create([
                    'url'=> $parteUrl.$compPic1,
                    'extension'=>strtolower($extension),
                    'id_usuario'=>$datos->id_usuario,
                    // 'conFecha'=>$datos->confecha,
                    // 'tamanomb'=>round($tamañoEnMegas, 2),
                    'id_tipo_documento'=>$datos->id_tipo_documento,
                    'id_usuario_crea'=>$IdUsuarioCrea,
                    'fecha_crea	'=>$fecha
                ]);
                $mensaje = ["Titulo"=>"Éxito","Respuesta"=>"Se cargó el archivo de manera correcta","Tipo"=>"success"];
            }else{
                $mensaje = ["Titulo"=>"Alerta","Respuesta"=>"Por favor seleccione un archivo","Tipo"=>"warning"];
            }
            // $usuarios->logo = 'storage/documentos/' . $compPic1;
        } catch (\Throwable $th) {
            dd($th);
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contactese con el administrador del sistema","Tipo"=>"error"];
        }
        return json_encode($mensaje);
    }
    public function EliminarDocumentoUsuario(){
        $datos=json_decode($_POST['data']);
        try{
            $flight = users_documentos::find($datos->id);
            $flight->delete();
            $mensaje = ["Titulo"=>"Éxito","Respuesta"=>"Se eliminó el registro de manera correcta","Tipo"=>"success"];
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error"];
        }
        return json_encode($mensaje);
    }
    public function Crear(Request $request){
        // return json_encode($mensaje);
         // $datos=json_decode($_POST['data']);
         $request = Request::capture(); // Captura la instancia de la solicitud actual
         $host = $request->getHost();
         $hostWithProtocol = $request->getSchemeAndHttpHost();
         // $datos=json_decode($_POST['data']);
         $string = $request->data;
         $datos = json_decode($string);
         // dd($datos);
         $nombreUsuario = Auth::user()->name;
         $Tipouser = Auth::user()->roles->first()->name;
         $IdUsuarioCrea = Auth::user()->id;
         $infoUsuario = Auth::user();
         $idEmpresa=$infoUsuario->idEmpresa;
         try{
                 if ($Tipouser!='admin') {
                     $datos->idEmpresa=$idEmpresa;
                 }
                 $usuario=User::find($datos->id);  
                 $usuario->password=bcrypt($datos->identificacion);
                 $usuario->name=$datos->name; 
                 $usuario->apellidos=$datos->apellidos; 
                 $usuario->email=$datos->email; 
                 $usuario->identificacion=$datos->identificacion;            
                 $usuario->id_zona=$datos->idZona;        
                 $usuario->id_cargo=$datos->cargo;        
                 $usuario->id_sucursal=$datos->idSucursal;
                 $usuario->estado=$datos->estado;      
                 $usuario->categorias=json_encode($datos->categorias);
                 $usuario->idEmpresa=$datos->idEmpresa;     
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
                     $path = $request->file('fileDato')->storeAs('public/documentos', $compPic1);
                     // $hostWithProtocol.
                     $parteUrl='storage/documentos/';
                     // $imgFirma=null;
                     $imgFirma=$parteUrl.$compPic1;
                     // $usuario->imgFirma=$imgFirma;     
                 }
                 $usuario->save();
                 $arrayIdsSucursales=json_decode($datos->idSucursal);
                 $fecha=date('Y-m-d');                
                 if (count($arrayIdsSucursales)> 0) {
                    for ($i=0; $i < count($arrayIdsSucursales) ; $i++) {                    
                     $id_usuario=$datos->id;
                     $idSucursal=$arrayIdsSucursales[$i];
                     users_sucursales::updateOrCreate(
                         ['id_usuario' => $id_usuario, 'id_sucursal' => $idSucursal],
                         ['fecha_modifica'=>$fecha,'id_usuario_modifica'=>$IdUsuarioCrea]                      
                     );
                    }
                 }
                 // users_sucursales
                 //para actualizar el rol se debe quitar primero y luego crear
                 // $usuario->roles()->detach($datos->role);
                 //crear nuevamente el rol
                 // $usuario->roles()->attach(Role::where('id', $datos->role)->first());
                //  $role=DB::table('role_user')->where('user_id', $datos->id)
                //  ->update(['role_id' => $datos->role]);
                $existingRole = DB::table('role_user')
                    ->where('user_id', $datos->id)
                    ->first();
                if ($existingRole) {
                    // Si ya existe, actualiza el role_id
                    DB::table('role_user')
                        ->where('user_id', $datos->id) 
                        ->update(['role_id' => $datos->role]);
                } else {
                    // Si no existe, crea una nueva relación
                    DB::table('role_user')->insert([
                        'user_id' => $datos->id,
                        'role_id' => $datos->role,
                    ]);
                }
                // $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se actualizó el registro de manera correcta","Tipo"=>"success"]; 
                           $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success",
                                        "email"=>$datos->email,
                                        "user"=>$datos->email,
                                        "pass"=>$datos->identificacion
                                        ]; 
            }catch(\Exception $e){
             // dd($e);
                $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se actualizó el registro de manera correcta","Tipo"=>"error"]; 
            }
         return json_encode($mensaje);
         //para imprimir de en la consola en network
         //dd($datos); 
    }
    public function Mostrar(){
        $datos=json_decode($_POST['data']);
        $usuario="";
        $role="";
        $categorias="";
        $nombreUsuario = Auth::user()->name;
        $Tipouser = Auth::user()->roles->first()->name;
        $IdUsuarioCrea = Auth::user()->id;
        try{
               $usuario=User::find($datos->id);  
               $role=DB::table('role_user')
               ->select('role_id')
               ->where('user_id', $datos->id)
               ->get();
            //    dd($role);
            $categorias =  DB::table('categorias')->get();
               $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","usuario"=>$usuario,'role'=>$role,"categorias"=>$categorias,"Tipouser"=>$Tipouser 
            ]; 
           }catch(\Exception $e){
               $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error","usuario"=>$usuario,'role'=>$role,"categorias"=>$categorias,"Tipouser"=>$Tipouser 
            ]; 
           }
        return json_encode($mensaje);
    }
    public function Actualizar(Request $request){
        // $datos=json_decode($_POST['data']);
        $request = Request::capture(); // Captura la instancia de la solicitud actual
        $host = $request->getHost();
        $hostWithProtocol = $request->getSchemeAndHttpHost();
        // $datos=json_decode($_POST['data']);
        $string = $request->data;
        $datos = json_decode($string);
        // dd($datos);
        $nombreUsuario = Auth::user()->name;
        $Tipouser = Auth::user()->roles->first()->name;
        $IdUsuarioCrea = Auth::user()->id;
        $infoUsuario = Auth::user();
        $idEmpresa=$infoUsuario->idEmpresa;
        try{
                if ($Tipouser!='admin') {
                    $datos->idEmpresa=$idEmpresa;
                }
                $usuario=User::find($datos->id);  
                $usuario->name=$datos->name; 
                $usuario->apellidos=$datos->apellidos; 
                $usuario->email=$datos->email; 
                $usuario->identificacion=$datos->identificacion;            
                $usuario->id_zona=$datos->idZona;        
                $usuario->id_cargo=$datos->cargo;        
                $usuario->id_sucursal=$datos->idSucursal;
                $usuario->estado=$datos->estado;      
                $usuario->categorias=json_encode($datos->categorias);
                $usuario->idEmpresa=$datos->idEmpresa;     
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
                    $path = $request->file('fileDato')->storeAs('public/documentos', $compPic1);
                    // $hostWithProtocol.
                    $parteUrl='storage/documentos/';
                    // $imgFirma=null;
                    $imgFirma=$parteUrl.$compPic1;
                    // $usuario->imgFirma=$imgFirma;     
                }
                $usuario->save();
                $arrayIdsSucursales=json_decode($datos->idSucursal);
                $fecha=date('Y-m-d');                
                if (count($arrayIdsSucursales)> 0) {
                   for ($i=0; $i < count($arrayIdsSucursales) ; $i++) {                    
                    $id_usuario=$datos->id;
                    $idSucursal=$arrayIdsSucursales[$i];
                    users_sucursales::updateOrCreate(
                        ['id_usuario' => $id_usuario, 'id_sucursal' => $idSucursal],
                        ['fecha_modifica'=>$fecha,'id_usuario_modifica'=>$IdUsuarioCrea]                      
                    );
                   }
                }
                // users_sucursales
                //para actualizar el rol se debe quitar primero y luego crear
                // $usuario->roles()->detach($datos->role);
                //crear nuevamente el rol
                // $usuario->roles()->attach(Role::where('id', $datos->role)->first());
                $role=DB::table('role_user')->where('user_id', $datos->id)
                ->update(['role_id' => $datos->role]);
               $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se actualizó el registro de manera correcta","Tipo"=>"success"]; 
           }catch(\Exception $e){
            // dd($e);
               $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se actualizó el registro de manera correcta","Tipo"=>"error"]; 
           }
        return json_encode($mensaje);
        //para imprimir de en la consola en network
        //dd($datos); 
    }
    public function obtenerSucursales()
    {
        $idZona=json_decode($_POST['data']);
        $sucursales="";
        try{
            if ($idZona!=0) {
                $sucursales=DB::table('sucursales')
                ->where('id_zona',$idZona)
                ->get();
            }
               $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se listo de manera correcta","Tipo"=>"success","sucursales"=>$sucursales]; 
           }catch(\Exception $e){
               $mensaje = ["Titulo"=>"Error","Respuesta"=>"Error,se presento un problema al momento de obtener sucursales","Tipo"=>"error","sucursales"=>$sucursales]; 
           }
        return json_encode($mensaje);
    }
    public function sincronizarProveedores($name,$email,$identificacion){
        try{         
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' =>bcrypt($identificacion),
                'identificacion' => $identificacion,           
                'estado'=>1    
            ]);
            $user
            ->roles()
            ->attach(Role::where('id',3)->first());                    
            $mensaje ='inserto' ;
        }catch(\Exception $e){
            $mensaje = 'no inserto'; 
        }
        echo $mensaje;
    }
    public function actualizarFechaVencimiento()
    {          
        $datos=json_decode($_POST['data']);
        $id=$datos->id;
        $fechaVencimiento=$datos->fechaVencimiento;
        try {
            $user=User::find($id);
            $user->fechaVencimientoMembresia=$fechaVencimiento;
            $user->save();
            // $idUser=Auth::user()->id;
            DB::table('role_user')
            ->where('user_id', $id)
            ->update(['role_id' => 3]);
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se actualizó la fecha de membresia de manera correcta","Tipo"=>"success"]; 
        } catch (\Throwable $th) {
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Error,se presentó un problema al momento de actualizar fecha de vencimiento membresia","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }
    public function enviarMailCreacion(Request $request)
    {
        try {
            $request = Request::capture();
            $host = $request->getHost();
            $hostWithProtocol = $request->getSchemeAndHttpHost();
            $datos=json_decode($_POST['data']);
            $email=$datos->email; 
            $usuario=$datos->user;
            $pass=$datos->pass;
            $idEmpresa = Auth::user()->idEmpresa;
            $registroEmpresa=empresas_sistemas::find($idEmpresa);
            $nombreEmpresa=$registroEmpresa->nombre;
            // require base_path("vendor/autoload.php");
            // require '../../../vendor/autoload.php';
            // require base_path("public/PHPMailer/src/Exception.php");
            // require base_path("public/PHPMailer/src/PHPMailer.php");
            // require base_path("public/PHPMailer/src/SMTP.php");
            //Load Composer's autoloader
            // require 'vendor/autoload.php';
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            // try {
                // $numeroCotizacion=$orden->consecutivo;
                $mail->Host       = 'mail.sodeker.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'heyner.becerra@sodeker.com';                     //SMTP username
                $mail->Password   = 'Sodeker123';                               //SMTP password
                // $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
                // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                // $mail->Username   = 'logistica@sodeker.co';                     //SMTP username
                // $mail->Password   = 'S0D@2016*_K3R';                               //SMTP password
                // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`465
                //Recipients
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->setFrom('contactenos@sodeker.com', 'Msi');
                $mail->addBCC('heyner.becerrasdk@gmail.com');               //Name is optional
                $mail->addBCC('jersoncamiloflorez@gmail.com');   
                // foreach ($users as $key ) {
                //     $mailAprobador=$key->correo;
                //     if ($email!="") {
                        $mail->addAddress($email);               //Name is optional
                //     }
                // }
                //Content
                $mensaje="";
                // $mail->AddEmbeddedImage($sImagen, 'imagen');
                // $url='https://sai.sodeker.com/dastone-v2.0/HTML/assets/images/logo-sm-sai.png';
                // $image = file_get_contents($url);
                // $imagenComoBase64 = base64_encode($image);
                // <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAJUlEQVR42u3NQQEAAAQEsJNcdFLw2gqsMukcK4lEIpFIJBLJS7KG6yVo40DbTgAAAABJRU5ErkJggg=="> 
                $mensaje.=utf8_decode('<div class="card" style="margin-bottom: 16px;
                background-color: #fff;
                border: 1px solid #e3ebf6;text-align:center;">');
                $mensaje.=utf8_decode('<div class="card-body p-0 auth-header-box" style=" background-color: #0c213a;">');
                $mensaje.=utf8_decode('<div class="text-center p-3">');
                // $mensaje.=utf8_decode('<a href="index.html" class="logo logo-admin">');
                $mensaje.=utf8_decode('<img src="'.$hostWithProtocol.'/storage/Msi-Logo%20blanco.png" height="50" alt="logo" class="auth-logo">');
                // $mensaje.=utf8_decode('</a>');
                // $mensaje.=utf8_decode('<h1 class="mt-3 mb-1 fw-semibold text-white font-18" style="color:white;">SAi</h1>  '); 
                // $mensaje.=utf8_decode('<p class="text-muted  mb-0" style="color:white;">SAi</p>');  
                $mensaje.=utf8_decode('</div>');
                $mensaje.=utf8_decode('</div>');
                $mensaje.=utf8_decode('<div class="card-body">');
                $mensaje.=utf8_decode('<h1>Gracias por registrarse</h1>');
                // $mensaje.=utf8_decode('Usuario :'.$usuario.'<br>');
                // $mensaje.=utf8_decode('Contraseña :'.$pass.'<br>');
                $mensaje.=utf8_decode('<p>Te damos la bienvenida al increible mundo de MSi. somos pioneros en soluciones de mantenimiento de vehiculos
                y lo vas a ver enseguida.</p>');
                $mensaje.=utf8_decode('<p>Todo lo que tienes que hacer es ingresar a tu navegador,a la siguiente url '.$hostWithProtocol.'
                y digitar tu usuario y contraseña.</p><br>'); 
                $mensaje.=utf8_decode('<p>Usuario : '.$usuario.'<p>');
                $mensaje.=utf8_decode('<p>Contraseña : '.$pass.'</p>');
                $mensaje.=utf8_decode('<p>Gracias por unirte a nosotros</p>');                      
                $mensaje.=utf8_decode('</div>');
                $mensaje.=utf8_decode('<div class="card-body bg-light-alt text-center">');
                // $mensaje.=utf8_decode('<span class="text-muted d-none d-sm-inline-block">Mannatthemes © <script> ');                                                              
                $mensaje.=utf8_decode('</div>');
                $mensaje.=utf8_decode('</div>');
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = utf8_decode('MSi - '.$nombreEmpresa.' >> Credenciales de ingreso');
                $mail->Body    = $mensaje;
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $mail->send();
                // }
            // } catch (Exception $e) {
            //     dd($e);
            //     // echo {$mail->ErrorInfo};
            // }
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"enviarMailCreacion","Tipo"=>"success"]; 
        } catch (\Throwable $th) {
        //    dd($th);
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
    public function guardarArchivoUsuario(Request $request)
    {
        $request = Request::capture(); // Captura la instancia de la solicitud actual
        $host = $request->getHost();
        $hostWithProtocol = $request->getSchemeAndHttpHost();
        // dd($hostWithProtocol);
        try {
            // $urlbucket='https://ventanarfiles.s3.us-east-2.amazonaws.com/';
            $string = $request->data;
            $datos = json_decode($string);
            $usuario=User::find($datos->id);  
            if ($request->hasFile('fileDato')) {
                $nombreCompletoArchvio = $request->file('fileDato')->getClientOriginalName();
                //cargar archivo a amazon s3
                $file = $request->file('fileDato');                
                // $paths3 = Storage::disk('s3')->put('uploads', $file, 'public');                
                $nombreDelArchivo = pathinfo($nombreCompletoArchvio, \PATHINFO_FILENAME);
                $nombreDelArchivo=$this->quitarAcentos($nombreDelArchivo);
                $extension = $request->file('fileDato')->getClientOriginalExtension();
                $tamañoEnBytes = $file->getSize();
                $tamañoEnMegas = $tamañoEnBytes / 1048576;
                $compPic1 = str_replace(' ', '_', $nombreDelArchivo) . '-' . rand() . '_' . time() . '.' . $extension;
                $path = $request->file('fileDato')->storeAs('public/documentos', $compPic1);
                $parteUrl=$hostWithProtocol.'/storage/documentos/';
                $parteUrl='storage/documentos/';
                $imgFirma=$parteUrl.$compPic1;
                $usuario->imgFirma=$imgFirma;   
                $mensaje = ["Titulo"=>"Éxito","Respuesta"=>"Se cargo el archivo de manera correcta","Tipo"=>"success"]; 
            } else if ($request->hasFile('file')) {
                    $nombreCompletoArchvio = $request->file('file')->getClientOriginalName();
                    //cargar archivo a amazon s3
                    $file = $request->file('file');
                    // $paths3 = Storage::disk('s3')->put('uploads', $file, 'public');
                    $nombreDelArchivo = pathinfo($nombreCompletoArchvio, \PATHINFO_FILENAME);
                    $nombreDelArchivo=$this->quitarAcentos($nombreDelArchivo);
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $tamañoEnBytes = $file->getSize();
                    $tamañoEnMegas = $tamañoEnBytes / 1048576;
                    $compPic1 = str_replace(' ', '_', $nombreDelArchivo) . '-' . rand() . '_' . time() . '.' . $extension;
                    $path = $request->file('file')->storeAs('public/documentos', $compPic1);
                    // $parteUrl=$hostWithProtocol.'/storage/documentos/';
                    $parteUrl='storage/documentos/';
                    $imgFirma=$parteUrl.$compPic1;
                     $usuario->imgFirma=$imgFirma;   
                    $mensaje = ["Titulo"=>"Éxito","Respuesta"=>"Se cargo el archivo de manera correcta","Tipo"=>"success"]; 
            } else {
                $mensaje = ["Titulo"=>"Alerta","Respuesta"=>"Por favor seleccione un archivo","Tipo"=>"warning"]; 
            }
            $usuario->save(); 
            // $usuarios->logo = 'storage/documentos/' . $compPic1;
        } catch (\Throwable $th) {
            //  dd($th);
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contactese con el administrador del sistema","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }
    public function ListarArchivosUsuario() {
        $datos=json_decode($_POST['data']);
        $listarAdjuntos="";
        try{ 
            $listarAdjuntos=DB::table('users')
                            ->where('id','=',$datos->idTercero)
                            ->first();
            $mensaje = ["Titulo"=>"Éxito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success","listarAdjuntos"=>$listarAdjuntos]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error","listarAdjuntos"=>$listarAdjuntos]; 
        }
        return json_encode($mensaje);       
    }


  //funciones moviles
  public function LoginMovil(Request $request)
  {
        try {
            $request->validate([            
                "email"=>'required|email',
                "password"=>'required'
                ]);
            $User=User::where("email","=",$request->email)->first();
            if (isset($User->id)) {
                if (Hash::check($request->password, $User->password)) {
                //creacion de token
                $token=$User->createToken("auth_token")->plainTextToken;
                //responder si esta ok
                return response()->json([
                    'status'=>'ok',
                    'msg'=>'usuario loggeado exitosamente',
                    "token"=> $token,
                    "user"=> $User,
        
                    ]);
                }else {
                return response()->json([
                    'status'=>'error',
                    'msg'=>'algo salio mal contacte con el administrador',
                    
                    ]);
                }
            }
        } catch (\Throwable $th) {

            return response()->json([
                'status'=>'error',
                'msg'=>'algo salio mal contacte con el administrador x',
                'error' => $th->getMessage(), 
                ]);
        }
  }
  public function RegisterMovil(Request $request)
  {
      try {
         $request->validate([
          "name"=>'required',
          "email"=>'required|email|unique:users',
          "password"=>'required|confirmed'
         ]);
         $user =new User();
         $user->name=$request->name;
         $user->email=$request->email;
         $user->password=bcrypt($request->password);
         $user->save();
         return response()->json([
          'status'=>'ok',
          'msg'=>'Se registro de manera correcta'

         ]);
      } catch (\Throwable $th) {
          return response()->json([
              'status'=>'error',
              'msg'=>'algo salio mal contacte con el administrador'
             ]);
      }
  }
  public function LogOutMovil()
  {
      try {
           
          return response()->json([
              'status'=>'ok',
              'msg'=>'cierre de sesion'             
             ]);
             auth()->user()->tokens()->delete();
      } catch (\Throwable $th) {
          return response()->json([
              'status'=>'error',
              'msg'=>'algo salio mal contacte con el administrador'
             ]);
      }
  }

  public function ProfileMovil()
  {
      try {
          return response()->json([
              'status'=>'ok',
              'msg'=>'acerca del prefil de usuario',
              "data"=> auth()->user(),
  
             ]);
      } catch (\Throwable $th) {
          return response()->json([
              'status'=>'error',
              'msg'=>'algo salio mal contacte con el administrador'
             ]);
      }
  }

  public function validarUsuario(Request $request)
  {
    // Obtener los datos del formulario
    $username = $request->input('username');
    $password = $request->input('password');

    // Validar el usuario en la base de datos
    $user = User::where('username', $username)->first();

    if ($user) {
        // Verificar la contraseña
        if (password_verify($password, $user->password)) {
            // Usuario válido, devolver información del usuario
            return response()->json([
                'existeUsuario' => true,
                'informacionUsuario' => $user
            ]);
        }
    }

      // Usuario no válido
      return response()->json(['existeUsuario' => false]);
  }
}
