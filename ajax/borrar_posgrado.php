<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
if (isset($_POST['no_control'],$_POST['registro']))
{
    if(is_numeric($_POST['no_control'])&& is_numeric($_POST['registro']))
    {
        if(borrar_posgrado($mysqli,$_POST['no_control'],$_POST['registro']))
        {
            $mensaje = 'EXITO';
            $respuesta = 'done';
        }//exito
        else
            $mensaje = 'ERROR';
    }
    else 
        $mensaje = 'ERROR';
}
else
    $mensaje = 'ERROR';
$salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
echo json_encode($salidaJson);
?>