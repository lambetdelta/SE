<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

$datos=Array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
if(isset($_POST['no_control'])){
    if(is_numeric($_POST['no_control'])){
    $resultado=  dt_sw($_POST['no_control'], $mysqli);
    if($resultado==FALSE){
        $datos['mensaje']='Error en BD';    
    }else{
        if($resultado->num_rows>0){
            $datos['respuesta']='1';
            $datos['mensaje']='bien';
            $datos['sw']=array();
            while ($fila=$resultado->fetch_object())
               $datos['sw'][]=$fila;     
        }else
            $datos['mensaje']='AÚN SIN COMPLETAR';
    
    }
    
    }
}
echo json_encode($datos,JSON_FORCE_OBJECT);