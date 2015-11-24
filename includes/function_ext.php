<?php
include_once 'psl-config.php';
include 'class.phpmailer.php';
include 'class.smtp.php';

function nuevo_pass_recuperacion($no_control,$nuevo_pass,$mysqli){
    try{   
        $nuevo_salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $nuevo_pass=hash('sha512', $nuevo_pass . $nuevo_salt);
            if($stmt=$mysqli->prepare('update datos_egresado set password=?, salt=? where no_control=?'))
            {
                $stmt->bind_param('ssi',$nuevo_pass,$nuevo_salt,$no_control); 
                $stmt->execute();    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0){
                    if(borrar_token($no_control, $mysqli)){
                        $stmt->close();
                        return TRUE;
                    }else{
                        $stmt->close();
                        return FALSE;}
                }
                else{
                    $stmt->close();
                    return false;}
                
            }
            else
                return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}
function borrar_token($no_control,$mysqli){
    try{
        if($query=$mysqli->prepare('delete from reseteo_contrasena where no_controlfk=?')){
            $query->bind_param('i',$no_control);
            $query->execute();
            if($query->affected_rows>0){
                $query->close();
                return TRUE;}
            else{
                $query->close();
                return FALSE;}
        }    
    }
     catch (Exception $e)
     {
        return FALSE;
     }    
 }
function validar_email($mysqli,$no_control,$email){//validar email dado por el usuario
    try{
        if ($stmt = $mysqli->prepare("SELECT  email FROM datos_egresado WHERE (no_control=? AND email=?)")){
		$stmt->bind_param('is',$no_control,$email); 
		$stmt->execute();    // Ejecuta la consulta preparada.
                $resultado=$stmt->get_result();
                $stmt->close();
		if($resultado->num_rows >0)
			return TRUE;
		else
			return FALSE;
	}
        else {
            return FALSE;
        }
    }  catch (Exception $e){
        return FALSE;
    }

}
function validar_token($mysqli,$no_control,$token){//buscar token creado
    try{
        if ($stmt = $mysqli->prepare("SELECT no_controlfk FROM reseteo_contrasena WHERE token = ?")){
		$stmt->bind_param('s',$token); 
		$stmt->execute();    // Ejecuta la consulta preparada.
                $resultado=$stmt->get_result();
                $stmt->close();
		if($resultado->num_rows >0)
                    {
                    $usuario = $resultado->fetch_assoc();
                    if( sha1($usuario['no_controlfk']) == $no_control )
                        return TRUE;
                    else 
                       return FALSE; 
                    }
		else
			return FALSE;
	}
        else {
            return FALSE;
        }
    }  catch (Exception $e){
        return FALSE;
    }

}

function anti_xss_cad($cadena){//limpiar cadenas recibidas
            $valor=$cadena;
            $valor=  trim($valor);
            $valor=  strip_tags($valor);
            // General   
            $valor=str_replace("<","",$valor);   
            $valor=str_replace(">","",$valor);   
            $valor=str_replace("{","",$valor);   
            $valor=str_replace("}","",$valor);   
            $valor=str_replace("[","",$valor);   
            $valor=str_replace("]","",$valor);   
            $valor=str_replace("(","",$valor);   
            $valor=str_replace(")","",$valor);   
            $valor=str_replace("/","",$valor);   
            $valor=str_replace("\\","",$valor);   

            // PHP   

            $valor= str_replace("function" , "" , $valor);   
            $valor= str_replace("php" , "" , $valor);   
            $valor= str_replace("echo" , "" , $valor);   
            $valor= str_replace("print" , "" , $valor);   
            $valor= str_replace("return" , "" , $valor);   

            // HTML   

            $valor= str_replace("html" , "" , $valor);   
            $valor= str_replace("body" , "" , $valor);   
            $valor= str_replace("head" , "" , $valor);   

            // JS   

            $valor= str_replace("script" , "" , $valor);   

            // Ajax y Otros   

            $valor= str_replace("xml" , "" , $valor);   
            $valor= str_replace("version" , "" , $valor);   
            $valor= str_replace("encoding" , "" , $valor);   

            // CSS   

            $valor= str_replace("style" , "" , $valor); 
            return $valor;
}


function enviar_email($no_control,$correo,$mysqli){//enviar email con solicitud de cambio de contraseña
    if($stmt=$mysqli->prepare('select nombre,apellido_p,apellido_m from datos_egresado where no_control=?'))
    {
        $stmt->bind_param('i',$no_control); 
        $stmt->execute();    // Ejecuta la consulta preparada.
        $resultado=$stmt->get_result(); 
        $stmt->close();
        if($resultado->num_rows >0){
            while ($fila=$resultado->fetch_assoc()){
                $nombre=$fila['nombre'];
                $apellido_m=$fila['apellido_m'];
                $apellido_p=$fila['apellido_p'];
                 }
            $nombre=$nombre.' '.$apellido_p.' '.$apellido_m;
            $email = new email();
            $asunto='Cambio de contraseña';
            $link=generarLinkTemporal($no_control,$mysqli);
            if(!$link){
            $mensaje = '<html>
                <head>
                   <title>Restablece tu contraseña</title>
                </head>
                <body>
                  <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta en el Sistema de Seguimiento de Egresados del ITTJ.</p>
                  <p>Lamentablemente has excedido la cantidad de solicitudes por lo que tendrás que esperar un dia para resetear tu contraseña.</p>
                </body>
            </html>';    
            }else{
            $mensaje = '<html>
                <head>
                <meta charset="UTF-8">  
                   <title>Restablece tu contraseña</title>
                </head>
                <body>
                <style>
                    .span{
                        color: #003300;
                        font-size: 22px;
                        background-color:#4CAF50;
                        border-radius:5px;
                        }
                </style>
                  <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta en el Sistema de Seguimiento de Egresados del ITTJ.</p>
                  <p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
                  <p>
                    <strong>Enlace para restablecer tu contraseña</strong></p>
                    <table>
                    <tr>
                    <td><a title="Enlace" href="'.$link.'"> Click Aqui </a></td>
                    </tr>
                    </table>
                    <span>Si el enlace no se carga bien copia el siguiente link y pegalo en tu navegador</span><br>
                    <span class="span">'.$link.'<span>
                </body>
            </html>';}
            if ( $email->enviar( $correo, $nombre , $asunto ,  $mensaje ) )
                return TRUE;
            else
            {
                return FALSE;
            }
        }
        else {
            echo'3';
        }
    }
     else 
    {
        echo'4';    
    }
}

function generarLinkTemporal($no_control,$mysqli){//link con solicitud de cambio de contraseña
       // Se genera una cadena para validar el cambio de contraseña
       $cadena = $no_control.rand(1,9999999).date('Y-m-d');
       $token = sha1($cadena);
       $consulta='select no_controlfk from reseteo_contrasena where no_controlfk='.$no_control;
       $resultado=$mysqli->query($consulta);
       if($resultado->num_rows<=4){
            if ($stmt = $mysqli->prepare("INSERT INTO reseteo_contrasena (no_controlfk,token,fecha) VALUES (?,?,NOW())")) 
            {
                 $stmt->bind_param('is', $no_control,$token); 
                 $stmt->execute();    // Ejecuta la consulta preparada.
                 if($stmt->affected_rows >0){
                     $enlace =$_SERVER["SERVER_NAME"].'/se/nueva_contrasena.php?no_control='.sha1($no_control).'&token='.$token;
                     return $enlace;

                 }
                 else
                     return FALSE;
             }else
                 return FALSE;
       }else {
           return FALSE;
              }
    }

class email  extends PHPMailer{//clase personalizada derivada de phpmailer

    //datos de remitente
    var $tu_email = 'lambetdelta@gmail.com';
    var $tu_nombre = 'Sistema de Seguimiento de Egresados';
    var $tu_password ='gvyfebxxvtzlmtum';

    /**
 * Constructor de clase
 */
    public function __construct()
    {
      //configuracion general
     $this->IsSMTP(); // protocolo de transferencia de correo
     $this->CharSet = 'UTF-8';
     $this->Host = 'smtp.gmail.com';  // Servidor GMAIL
     $this->Port = 465; //puerto
     $this->SMTPAuth = true; // Habilitar la autenticación SMTP
     $this->Username = $this->tu_email;
     $this->Password = $this->tu_password;
     $this->SMTPSecure = 'ssl';  //habilita la encriptacion SSL
     //remitente
     $this->From = $this->tu_email;
     $this->FromName = $this->tu_nombre;
    }

    /**
 * Metodo encargado del envio del e-mail
 */
    public function enviar( $para, $nombre, $titulo , $contenido)
    {
       $this->AddAddress( $para ,  $nombre );  // Correo y nombre a quien se envia
       $this->WordWrap = 50; // Ajuste de texto
       $this->IsHTML(true); //establece formato HTML para el contenido
       $this->Subject =$titulo;
       $this->Body    =  $contenido; //contenido con etiquetas HTML
       $this->AltBody =  strip_tags($contenido); //Contenido para servidores que no aceptan HTML
       //envio de e-mail y retorno de resultado
       return $this->Send() ;
   }

}//--> fin clase
