<?php 
include '../includes/functions_adm.php';
include '../includes/conexion-bd-adm.php';
$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
if (isset($_POST['no_control']))
{
    if(is_numeric($_POST['no_control']))
    {
        $res=borrar_egresado($mysqli,$_POST['no_control']);
        if($res==1)
        {
            $mensaje = 'Exito';
            $respuesta = '1';
        }//exito
        else
            if($res==3)
                $mensaje = 'Fallo en la bd';
            else
                $mensaje = 'Sin coincidencias';
    }
    else 
        $mensaje = 'ERROR';
}
else
    $mensaje = 'ERROR';
$salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
echo json_encode($salidaJson);
