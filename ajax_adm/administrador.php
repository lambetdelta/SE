<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensage']='Error en envío de datos';
    $resultado=  administrador( $mysqli);
    if($resultado==FALSE){
        $datos['mensage']='Error en BD';    
    }else{
        if($resultado->num_rows>0){
            $datos['respuesta']='1';
            $datos['mensage']='bien';
            $datos['carrera']=array();
            while ($fila=$resultado->fetch_object())
               $datos['carrera'][]=$fila;     
        }else
            $datos['mensage']='Sin datos disponibles';
    
    }   
   
echo json_encode($datos,JSON_FORCE_OBJECT);
