<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$datos=array();
$datos['mensaje']='Error en envío';
$datos['respuesta']='0';
if (isset($_POST['registro'],$_POST['no_control']))
{
    if(is_numeric($_POST['no_control'])&& is_numeric($_POST['registro']))
    {
        if(borrar_social($mysqli,$_POST['no_control'],$_POST['registro']))
        {
            $datos['mensaje']='bien';
            $datos['respuesta']='1';
        }
        else
            $datos['mensaje']='Error';//error en guardado
    } 
}


echo json_encode($datos);