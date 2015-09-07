<?php 
include '../includes/functions.php';
include '../includes/db_connect.php';

sleep(3);
$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
if (isset($_POST['form'],$_POST['no_control']))
{
    if(is_numeric($_POST['no_control']))
    {    
        $form=array();
        parse_str($_POST['form'],$form);
        $form=anti_xss($form);
        if(guardar_posgrado($mysqli,$_POST['no_control'],$form['posgrado'],$form['nombre'],$form['escuela'],$form['titulado']))
        {
            $mensaje = 'EXITO';
            $respuesta = 'done';
        }//exito
        else
            $mensaje = 'ERROR ';
    }
    else 
        echo $mensaje='ERROR';
}
else
    $mensaje = 'ERROR';
$salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
echo json_encode($salidaJson);
?>
