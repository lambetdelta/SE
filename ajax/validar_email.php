<?php
include_once '../includes/db_connect.php';
include_once '../includes/function_ext.php'; 

$mensaje='Error en envío';
$respuesta='error';

if(isset($_POST['email'],$_POST['no_control'])){
    $no_control=anti_xss_cad($_POST['no_control']);
    $email=anti_xss_cad($_POST['email']);
    if(validar_email($mysqli,$no_control, $email)){
        if(enviar_email($no_control, $email, $mysqli)){
            $mensaje='Solicitud de reseteo de contraseña enviado a tu correo';
            $respuesta='hecho'; 
        }  else {
          $mensaje='Falla en el envio del email';  
        }   
    }
    else {
        $mensaje='Email o no: de control Inválido';
       }
}

$salidaJson=array('respuesta'=>$respuesta,'mensaje'=>$mensaje);
echo json_encode($salidaJson);