<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensage']='Error en envío de datos';
if(isset($_POST['dato'],$_POST['no_registro'],$_POST['cantidad'])){
    $dato=  anti_xss_cad($_POST['dato']);
    $no_registro=  anti_xss_cad($_POST['no_registro']);
    $cantidad=  anti_xss_cad($_POST['cantidad']);
    $resultado=  buscar($dato, $mysqli,$cantidad,$no_registro);
    if($resultado=='vacio'){
        $datos['mensage']='Sin coincidencias';   
    }else{
        if($resultado==FALSE){
        $datos['mensage']='Error en BD';    
        }else{
            if($resultado->num_rows>0){
                $datos['respuesta']='1';
                $datos['mensage']='bien';
                $datos['egresado']=array();
                while ($fila=$resultado->fetch_object())
                   $datos['egresado'][]=$fila;     
            }   
        }
    
    }
}
echo json_encode($datos,JSON_FORCE_OBJECT);
