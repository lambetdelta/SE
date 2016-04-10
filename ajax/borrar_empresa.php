<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';


$datos=array();
$datos['mensaje']='Error en envío';
$datos['respuesta']='0';
if (isset($_POST['no_control'],$_POST['registro']))
{
    $mysqli->autocommit(false);
    if(is_numeric($_POST['no_control'])&& is_numeric($_POST['registro']))
    {
        if(guardar_historial($mysqli,$_POST['no_control'],$_POST['registro']))
        {
            if(borrar_empresa($mysqli,$_POST['no_control'],$_POST['registro']))
            {
                $mysqli->commit();
               $datos['mensaje']='hecho';
               $datos['respuesta']='1';
            }
            else
            {
                $mysqli->rollback();
            }	
        }
        else
        {
            $mysqli->rollback();
            $datos['mensaje']='Imposible guardar en historial';
        }
    }

}


echo json_encode($datos);