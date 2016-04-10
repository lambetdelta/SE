<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$form=array();

$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
if (isset($_POST['form'],$_POST['no_control']))
{
    if(is_numeric($_POST['no_control']))
    {
        parse_str($_POST['form'],$form);
        $form=anti_xss($form);
        if(actualizar_residencia($mysqli,$_POST['no_control'],$form['residencia']))
        {
            $mensaje = 'EXITO';
            $respuesta = 'done';
        }//exito
        else
            $mensaje = 'EXITO ';
    }
    else $mensaje='ERROR';
}
else
    $mensaje = 'ERROR RECEPCIÓN DE DATOS';
$salidaJson = array("respuesta" => $respuesta,"mensaje" => $mensaje);
echo json_encode($salidaJson);
?>