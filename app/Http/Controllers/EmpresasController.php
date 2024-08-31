<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\empresas;
use App\Models\empresas_sistemas;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\Exception;
class EmpresasController extends Controller
{
    public function index()
    {
        return view('empresas.index');
    }
    public function Listar() {
        $empresas="";
        try{

            $Tipouser = Auth::user()->roles->first()->name;
            $idUsuarioCrea = Auth::user()->id;
            if ($Tipouser=='admin') {
                # code...
                $empresas =  empresas::get();
            }else{
                $empresas = DB::table('empresas')
                            ->where('idUsuarioCrea','=',$idUsuarioCrea)
                            ->get();
            }
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la informaci&oacuten satisfatoria","Tipo"=>"success","empresas"=>$empresas]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error","empresas"=>$empresas]; 
        }
        return json_encode($mensaje);       
    }
    public function Eliminar(){
        $datos=json_decode($_POST['data']);
        try{
            $flight = empresas::find($datos->id);
            $flight->delete();
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se eliminó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salio mal contacte con al administrador del sistema.","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }
    public function Crear(){
        $datos=json_decode($_POST['data']);
        $ultimoId="";
        try{         
            $Tipouser = Auth::user()->roles->first()->name;
            $idUser = Auth::user()->id;
            $existe = DB::table('empresas')
                ->where('identificacion','=',$datos->identificacion)
                ->get();
            if (count($existe) > 0) {
                $mensaje = ["Titulo"=>"Exito","Respuesta"=>"la identificacion existe ya en el sistema","Tipo"=>"success","ultimoId"=>$ultimoId]; 
            }else{
                $empresa = empresas::create([
                    'nombre' => $datos->nombre, 
                    'identificacion' => $datos->identificacion,
                    'idUsuarioCrea' => $idUser,
                ]);    
                if ($datos->email !="" && $datos->email !=null ) {
                    $fechamembresia=date('Y-m-16');
                    $user = User::create([
                        'name' => $datos->nombre,
                        'email' => $datos->email,
                        'password' =>bcrypt($datos->identificacion),
                        'identificacion' => $datos->identificacion,                       
                        'estado'=>1,
                        'bpass'=>$datos->identificacion,
                        'fechaVencimientoMembresia'=>$fechamembresia,
                        'estadoVencido'=>0
                    ]);
                    $user
                    ->roles()
                    ->attach(Role::where('id', 3)->first());  


                    EmpresasController::enviarMailCreacion($datos->email,$datos->identificacion);
                }
                $registro = empresas::latest('id')->first();
                $ultimoId=$registro->id;
                $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","ultimoId"=>$ultimoId,
                "email"=>$datos->email, 
                "user"=>$datos->email,
                "pass"=>$datos->identificacion
            ]; 
            }
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
    }
    public function Mostrar(){
        $datos=json_decode($_POST['data']);
        $empresa="";
        try{
            $empresa=empresas::find($datos->id);                      
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se creó el registro de manera correcta","Tipo"=>"success","empresa"=>$empresa]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se creó el registro de manera correcta","Tipo"=>"error","empresa"=>$empresa]; 
        }
        return json_encode($mensaje);
    }
    public function Actualizar(){
        $datos=json_decode($_POST['data']);
        try{
            $Tipouser = Auth::user()->roles->first()->name;
            $idUser = Auth::user()->id;
            $empresa=empresas::find($datos->id);  
            // $empresa->nombre=$datos->name;    
            $empresa->nombre = $datos->nombre; 
            $empresa->identificacion = $datos->identificacion;
            $empresa->idUsuarioCrea = $idUser;                  
            $empresa->save();             
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se actualizó el registro de manera correcta","Tipo"=>"success"]; 
        }catch(\Exception $e){
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"No se actualizó el registro de manera correcta","Tipo"=>"error"]; 
        }
        return json_encode($mensaje);
        //para imprimir de en la consola en network
        //dd($datos); 
    }

    public function enviarMailCreacion($email,$pass)
    {

        // $datos=json_decode($_POST['data']);
        $email=$email; 
        $usuario=$email;
        $pass=$pass;
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
            $mail->Username   = 'logistica@sodeker.com';                     //SMTP username
            $mail->Password   = 'S0D@2016*_K3R';                               //SMTP password
            // $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom('logistica@sodeker.com', 'Msi');
            $mail->addAddress('heyner.becerrasdk@gmail.com');               //Name is optional
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
             $mensaje.=utf8_decode('<img src="https://globalmsi.sodeker.com/storage/Msi%20Logo.png" height="50" alt="logo" class="auth-logo">');
            // $mensaje.=utf8_decode('</a>');
            // $mensaje.=utf8_decode('<h1 class="mt-3 mb-1 fw-semibold text-white font-18" style="color:white;">SAi</h1>  '); 
            // $mensaje.=utf8_decode('<p class="text-muted  mb-0" style="color:white;">SAi</p>');  
            $mensaje.=utf8_decode('</div>');
            $mensaje.=utf8_decode('</div>');
            $mensaje.=utf8_decode('<div class="card-body">');
            $mensaje.=utf8_decode('<h1>Gracias por registrarse</h1>');
            // $mensaje.=utf8_decode('Usuario :'.$usuario.'<br>');
            // $mensaje.=utf8_decode('Contraseña :'.$pass.'<br>');
            $mensaje.=utf8_decode('<p>Te damos la bienvenida al increible mundo de msi. somos pioneros en soluciones de cotizaciones web
            y lo vas a ver enseguida.</p>');
            $mensaje.=utf8_decode('<p>todo lo que tienes que hacer es ingresar a tu navegador,a la siguiente url https://globalmsi.sodeker.com/
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
            $mail->Subject = utf8_decode('Msi >> Credenciales');
            $mail->Body    = $mensaje;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            // }
        // } catch (Exception $e) {
            
        //     dd($e);
        //     // echo {$mail->ErrorInfo};
        // }
        $mensaje = ["Titulo"=>"Exito","Respuesta"=>"enviarMailCreacion","Tipo"=>"success"]; 

        // return json_encode($mensaje);
    }


    public function MostrarPerfilEmpresa()
    {
        // $datos=json_decode($_POST['data']);
        $Perfil="";
        try {
            $idEmpresa = Auth::user()->idEmpresa; 
            $Perfil=empresas_sistemas::find($idEmpresa);
            $mensaje = ["Titulo"=>"Exito","Respuesta"=>"Se realizó consulta de manera correcta","Tipo"=>"success","Perfil"=>$Perfil]; 
        } catch (\Throwable $th) {
            $mensaje = ["Titulo"=>"Error","Respuesta"=>"Algo salió mal por favor contacte con el administrador","Tipo"=>"error","Perfil"=>$Perfil]; 
        }
        return json_encode($mensaje); 
    }

    public function GuardarFileEmpresa(Request $request)
    {
        $idEmpresa = Auth::user()->idEmpresa;
        $compPic1 = "";
    
        try {
            $string = $request->data;
            $datos = json_decode($string);
    
            if ($request->hasFile('filePerfil')) {
                $file = $request->file('filePerfil');
                $compPic1 = $this->generateFileName($file);
                $file->storeAs('public/imagenesEmpresa', $compPic1);
            } 
            
            // elseif ($datos->accion != 'nuevo' && !empty($datos->info)) {
            //     $compPic1 = $this->base64ToImage($datos->info);
            // }
    
            $empresas_sistemas = empresas_sistemas::find($idEmpresa);
            if ($empresas_sistemas!=null) {
                # code...
                if ($compPic1 != "") {
                    $empresas_sistemas->img = 'storage/imagenesEmpresa/' . $compPic1;
                    $empresas_sistemas->save();
                }
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
