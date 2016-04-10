<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$form=array();
$datos=array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío';
if (isset($_POST['form'],$_POST['no_control'],$_POST['registro']))
{
    parse_str($_POST['form'],$form);
    $form=anti_xss($form);
    if((is_numeric($_POST['no_control']))&&(is_numeric($_POST['registro'])))
    {
        $valides=validarHistorial($form['nombre'],$form['tel'],$form['email'],$form['web']);
        if($valides['resultado']){
            if(actualizar_historial($mysqli,$_POST['no_control'],$form['nombre'],$form['tel'],$form['web'],$form['email'],$_POST['registro']))
            {
                $datos['respuesta']='1';
                $datos['mensaje']='bien';
            }
            else
                $datos['mensaje']='Error en guardado';
        }else
             $datos['mensaje']=$valides['mensaje'];
    }
}

echo json_encode($datos);