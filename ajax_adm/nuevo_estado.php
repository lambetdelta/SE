<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
$form=array();
if (isset($_POST['form'])){
    parse_str($_POST['form'], $form);
    $form=  anti_xss($form);
        $res=nuevo_estado($mysqli,$form['estado']);
        if($res==1){
            $datos['respuesta']='1';
            $datos['mensaje']='Bien';
        }else{
            if($res==3)
               $datos['mensaje']='Error en BD';
            else
                $datos['mensaje']='Error inesperado';
        }
}

echo json_encode($datos);