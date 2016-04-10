<?php
include '../includes/db_connect.php';
include '../includes/functions.php';


$mensaje='ERROR EN ENVÍO';
$respuesta='falla';
if(isset($_POST['no_control'],$_POST['form']))
{
    if (is_numeric($_POST['no_control'])) {
        $form=array();
        parse_str($_POST['form'],$form);
        $form=anti_xss($form);
        if(strlen($form['p'])==128 and strlen($form['x'])==128)//verificar longitud de pass recibido
        {
            if(nuevo_pass($_POST['no_control'],$form['p'],$form['x'],$mysqli))
            {
                $respuesta='hecho';
                $mensaje='EXITO';
            }
            else 
            $mensaje='Contraseña erronea';            
        }
        else
        $mensaje='ERROR';    
    }
    else
    $mensaje='ERROR';    
    
}
$salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
echo json_encode($salidaJson);
