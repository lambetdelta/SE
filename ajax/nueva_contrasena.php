<?php
include '../includes/functions.php';
include '../includes/db_connect.php';


$mensaje='ERROR EN ENVÍO';
$respuesta='falla';
if(isset($_POST['no_control'],$_POST['form']))
{
    if (is_numeric($_POST['no_control'])) {
        $form=array();
        parse_str($_POST['form'],$form);
        $form=anti_xss($form);
        if(nuevo_pass($_POST['no_control'],$form['p'],$form['x'],$mysqli)){
            $respuesta='hecho';
            $mensaje='EXITO';
        }
        else 
           $mensaje='Contraseña erronea';           
    }
    else
    $mensaje='ERROR';    
    
}
$salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
echo json_encode($salidaJson);
