<?php
namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CorreoController extends Controller
{
    public function enviarCorreo($destinatarios, $asunto, $cuerpo)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            // $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP   
            $mail->Host       = 'mail.sodeker.com';                     //Set the SMTP server to send through 
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
             $mail->Username   = 'heyner.becerra@sodeker.com';                     //SMTP username
            // $mail->Username   ='logistica@sodeker.com';
            $mail->Password   = 'Sodeker123';                               //SMTP password     
            // $mail->SMTPSecure = 'ssl';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`        
            $mail->SMTPOptions = array( 
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->setFrom('contactenos@sodeker.com', 'MSi');
            // $mail->setFrom('logistica@sodeker.com', 'SKALA');
            
            $mail->addBCC('heynerlbr@gmail.com');
            $mail->addBCC('hasbel.africano@sodeker.co');
            $mail->addBCC('jersoncamiloflorez@gmail.com');
            // $destinatarios = json_decode($destinatarios);
            foreach ($destinatarios as $destinatario) {
                $mail->addAddress($destinatario);
            }
            $mail->isHTML(true);
            $mail->Subject = utf8_decode($asunto);
            $mail->Body = utf8_decode($cuerpo);
            $mail->send();
            // Limpiar después de enviar
            $mail->clearAddresses();
            $mail->clearAttachments();
            return true;
        } catch (Exception $e) {
            
            return $e;
        }
    }
    public function enviarCorreoPersonalizado($destinatariosArray,$asunto,$cuerpoHmtl)
    {
        $destinatarios = $destinatariosArray;

        // $destinatarios= explode(",", $destinatarios);
        $asunto = $asunto;
        $cuerpo = $cuerpoHmtl;
        $envio=$this->enviarCorreo($destinatarios, $asunto, $cuerpo);
        if ($envio) {
            return "Correo enviado correctamente.";
        } else {
            return "Error al enviar el correo.";
        }
    }
    public function enviarCorreoPersonalizadoPost()
    {
        $datos = json_decode($_POST['data']);
        try {
            $destinatarios =  $datos->destinatariosArray;
            $destinatarios= json_decode($destinatarios);
            $asunto = $datos->asunto;            
            $cuerpo = $datos->cuerpoHtml;
            $envio=$this->enviarCorreo($destinatarios, $asunto, $cuerpo);
            if ($envio) {
                $mensaje=["mensaje"=>"Correo enviado correctamente."];
            } else {
                $mensaje=["mensaje"=>"Error al enviar el correo.".$envio];
            }
        } catch (\Throwable $th) {
            $mensaje=["mensaje"=>"Error al enviar el correo.".$th];
            //    dd($th);
        }
        return json_encode($mensaje);
    }
    public function enviarCorreoPersonalizadoGet(Request $request,$destinatariosArray,$asunto,$cuerpoHmtl)
    {
        $destinatariosArray = json_decode($request->input('destinatariosArray'));
        $asunto = $request->input('asunto');
        $cuerpoHmtl = $request->input('cuerpoHmtl');        
        if ($this->enviarCorreo($destinatarios, $asunto, $cuerpo)) {
            $mensaje=["mensaje"=>"Correo enviado correctamente."];
        } else {
            $mensaje=["mensaje"=>"Error al enviar el correo."];
        }
        return json_encode($mensaje);
    }



    public function enviarCorreoPersonalizadoGetConAdjunto($destinatariosArray,$asunto,$cuerpoHmtl,$adjunto)
    {

        // dd($destinatariosArray);
        // $destinatariosArray = json_decode($request->input('destinatariosArray'));
        // $asunto = $request->input('asunto');
        // $cuerpoHmtl = $request->input('cuerpoHmtl');        
        if ($this->enviarCorreoConAdjunto($destinatariosArray, $asunto, $cuerpoHmtl,$adjunto)) {
            $mensaje=["mensaje"=>"Correo enviado correctamente."];
        } else {
            $mensaje=["mensaje"=>"Error al enviar el correo."];
        }
        return json_encode($mensaje);
    }
    public function enviarCorreoConAdjunto($destinatarios, $asunto, $cuerpo,$adjunto)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            // $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP   
            $mail->Host       = 'mail.sodeker.com';                     //Set the SMTP server to send through 
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
             $mail->Username   = 'heyner.becerra@sodeker.com';                     //SMTP username
            // $mail->Username   ='logistica@sodeker.com';
            $mail->Password   = 'Sodeker123';                               //SMTP password     
            // $mail->SMTPSecure = 'ssl';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`        
            $mail->SMTPOptions = array( 
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->setFrom('contactenos@sodeker.com', 'MSi');
            // $mail->setFrom('logistica@sodeker.com', 'SKALA');
            
            $mail->addBCC('heynerlbr@gmail.com');
            $mail->addBCC('hasbel.africano@sodeker.co');
            $mail->addBCC('jersoncamiloflorez@gmail.com');
            // $destinatarios = json_decode($destinatarios);
            foreach ($destinatarios as $destinatario) {
                // dd($destinatario->email);
                $mail->addAddress($destinatario->email);
            }

            $mail->isHTML(true);
            $mail->Subject = utf8_decode($asunto);
            $mail->Body = utf8_decode($cuerpo);
            $mail->addAttachment($adjunto);
            $mail->send();
            // Limpiar después de enviar
            $mail->clearAddresses();
            $mail->clearAttachments();
            return true;
        } catch (Exception $e) {
            
            return $e;
        }
    }
}
