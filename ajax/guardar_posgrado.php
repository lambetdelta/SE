<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';


$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
if (isset($_POST['form'],$_POST['no_control']))
{
    if(is_numeric($_POST['no_control']))
    {    
        $form=array();
        parse_str($_POST['form'],$form);
        $form=anti_xss($form);
        if(strlen($form['titulado'])==2){
            if(validarPosgrado($form['posgrado'])){
                if(guardar_posgrado($mysqli,$_POST['no_control'],$form['posgrado'],$form['nombre'],$form['escuela'],$form['titulado']))
                {
                    $mensaje = 'EXITO';
                    $respuesta = 'done';
                }//exito
                else
                    $mensaje = 'ERROR ';
            }else
                $mensaje = 'Campo posgrado inválido ';
        }else
        $mensaje = 'Campo titulo inválido ';
    }
}

$salidaJson = array('respuesta' => $respuesta, 'mensaje' => $mensaje);
echo json_encode($salidaJson);
?>
