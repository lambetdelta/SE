<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensage']='Error en envío de datos';
if(isset($_POST['no_registro'])){
    if(is_numeric($_POST['no_registro'])){
        $resultado=  buscar_todos($mysqli,$_POST['no_registro']);
        if($resultado==FALSE){
            $datos['mensage']='Error en BD';    
        }else{
            if($resultado->num_rows>0){
                $datos['respuesta']='1';
                $datos['mensage']='bien';
                $datos['egresado']=array();
                while ($fila=$resultado->fetch_object())
                   $datos['egresado'][]=$fila;     
                }else{
                    $datos['mensage']='Sin coincidencias';
                }

            }
   
    }
 }
echo json_encode($datos,JSON_FORCE_OBJECT);
