<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$form=array();
$datos=array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío';
if (isset($_POST['form'],$_POST['no_control']))
{
    parse_str($_POST['form'],$form);
    $form=anti_xss($form);
    if(is_numeric($_POST['no_control']))
    {
        if(!contar_sw($mysqli,$_POST['no_control']))
        {
            if(guardar_sw($mysqli,$_POST['no_control'],$form['sw']))
                 {
                $datos['respuesta']='1';
                $datos['mensaje']='Bien';  
                }
           else
                $datos['mensaje']='Error';
        }
        else
           $datos['respuesta']='3'; 
    }
}
 echo json_encode($datos);