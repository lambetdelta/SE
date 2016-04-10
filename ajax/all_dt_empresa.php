<?php

include '../includes/conexion-bd-adm.php';
include '../includes/functions.php';

$datos=Array();
$datos['respuesta']='0';
$datos['mensage']='Error en envío de datos';
if(isset($_POST['codigo_empresa'])){
    if(is_numeric($_POST['codigo_empresa'])){
    $resultado=  dt_empresa_completa($_POST['codigo_empresa'], $mysqli);
    if($resultado==FALSE){
        $datos['mensage']='Error en BD';    
    }else{
        if($resultado->num_rows>0){
            $datos['respuesta']='1';
            $datos['mensaje']='bien';
            $datos['empresa']=array();
            while ($fila=$resultado->fetch_object())
               $datos['empresa'][]=$fila;     
        }else
            $datos['mensage']='Error en BD';
    
    }
    
    }
}
echo json_encode($datos,JSON_FORCE_OBJECT);