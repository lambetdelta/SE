<?php

include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$resultado='0';
$mensaje='Datos inválidos';
$img='Imagenes/businessman_green.png';
if(isset($_POST['no_control'])){
    $no_control=$_POST['no_control'];
    if(is_numeric($no_control)){
        $url=cargar_foto($mysqli,$no_control);
        if($url==FALSE)
                $mensaje='Fallo en BD';
        else{
            $resultado='1';
            $mensaje=' ';
            $img=$url;
        }
       
    }
}  
$json=array('resultado'=>$resultado,'mensaje'=>$mensaje,'imagen'=>$img);
echo json_encode($json);
    

    

