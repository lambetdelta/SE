<?php

include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
sleep(3);
$datos=Array();
$datos['respuesta']='0';
$datos['mensage']='Error en envío de datos';
if(isset($_POST['no_control'])){
    if(is_numeric($_POST['no_control'])){
    $resultado=  dt_historial($_POST['no_control'], $mysqli);
    if($resultado==FALSE){
        $datos['mensage']='Error en BD';    
    }else{
        if($resultado->num_rows>0){
            $datos['respuesta']='1';
            $datos['mensage']='bien';
            $datos['empresa']=array();
            while ($fila=$resultado->fetch_object())
               $datos['empresa'][]=$fila;     
        }else
            $datos['mensage']='Error en BD';
    
    }
    
    }
}
echo json_encode($datos,JSON_FORCE_OBJECT);