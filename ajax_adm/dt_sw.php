<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensage']='Error en envío de datos';
if(isset($_POST['no_control'])){
    if(is_numeric($_POST['no_control'])){
    $resultado=  dt_sw($_POST['no_control'], $mysqli);
    if($resultado==FALSE){
        $datos['mensage']='Error en BD';    
    }else{
        if($resultado->num_rows>0){
            $datos['respuesta']='1';
            $datos['mensage']='bien';
            $datos['sw']=array();
            while ($fila=$resultado->fetch_object())
               $datos['sw'][]=$fila;     
        }else
            $datos['mensage']='AÚN SIN COMPLETAR';
    
    }
    
    }
}
echo json_encode($datos,JSON_FORCE_OBJECT);