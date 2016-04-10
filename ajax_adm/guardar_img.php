<?php
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';

if(isset($_FILES['banner_institucion'],$_FILES['banner'],$_FILES['director'])){
    $banner_ins=$_FILES['banner_institucion'];
    $banner=$_FILES['banner'];
    $firma=$_FILES['director'];
    $validar_banner=  validar_img($banner_ins);
    if($validar_banner['resultado']==TRUE){
        if(move_uploaded_file($banner_ins['tmp_name'], '../Imagenes/banner_ittj.png')){
            $validar_banner=  validar_img($banner);
            if($validar_banner['resultado']==TRUE){
                if(move_uploaded_file($banner['tmp_name'], '../Imagenes/banner.png')){
                    $validar_banner= validar_firma($firma);
                    if($validar_banner['resultado']==TRUE){
                        if(move_uploaded_file($firma['tmp_name'], '../Imagenes/firmaDirector.JPG')){
                            $datos['respuesta']='1';
                            $datos['mensaje']='bien';
                        }else
                            $datos['mensaje']='Error guardado de la firma del director'; 
                    }else
                        $datos['mensaje']='Imagen de la firma del director:'.$validar_banner['mensaje']; 
                }else
                   $datos['mensaje']='Error guardado del banner del sistema';  
            }else
                $datos['mensaje']='Imagen del sistema:'.$validar_banner['mensaje']; 
        }  else {
           $datos['mensaje']='Error guardado del banner de la institución'; 
        }
    }  else {
       $datos['mensaje']='Imagen de la institución:'.$validar_banner['mensaje']; 
    }
}

echo json_encode($datos);