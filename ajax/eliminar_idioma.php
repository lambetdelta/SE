<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$datos=array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío';
if (isset($_POST['registro'],$_POST['no_control']))
{
     if(is_numeric($_POST['no_control'])&& is_numeric($_POST['registro']))
     {     
        if(borrar_idioma($mysqli,$_POST['no_control'],$_POST['registro']))
        {
            $datos['respuesta']='1';
            $datos['mensaje']='Exito';
        }
        else
            $datos['mensaje']='Error';
     }
}
 
echo json_encode($datos);