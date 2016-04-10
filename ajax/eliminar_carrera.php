<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$datos=array();
$dato['mensaje']='Error en envío';
$dato['respuesta']='0';
if (isset($_POST['registro'],$_POST['no_control']))
{
     if(is_numeric($_POST['no_control'])&& is_numeric($_POST['registro']))
     {
        if(borrar_dt_academicos($mysqli,$_POST['no_control'],$_POST['registro']))
        {   
            $dato['respuesta']='1';
            $dato['mensaje']='EXITO';
        }
        else
            $dato['mensaje']='Error en BD';
     }      
}

echo json_encode($dato);