<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

$datos=Array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
if(isset($_POST['no_control'])){
    if(is_numeric($_POST['no_control'])){
    $resultado=  dt_historial($_POST['no_control'], $mysqli);
    if($resultado==FALSE){
        $datos['mensaje']='Error en BD';    
    }else{
        if($resultado->num_rows>0){
            $datos['respuesta']='1';
            $datos['mensaje']='bien';
            $datos['empresa']=array();
            while ($fila=$resultado->fetch_object())
               $datos['empresa'][]=$fila;     
        }else
            $datos['mensaje']='AÚN SIN COMPLETAR';
    
    }
    
    }
}
echo json_encode($datos,JSON_FORCE_OBJECT);