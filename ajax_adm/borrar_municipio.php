<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
$form=array();
if (isset($_POST['form'])){
    parse_str($_POST['form'], $form);
    $form=  anti_xss($form);
    $validar=  validarEstado($mysqli, $form['estado']);
    if($validar==1){
        $validar=  validarMun($form['codigo'], $mysqli);
        if($validar==1){
            $res=borrar_municipio($mysqli,$form['codigo']);
            if($res==1){
                $datos['respuesta']='1';
                $datos['mensaje']='Bien';
            }else{
                if($res==3)
                   $datos['mensaje']='Error en BD';
                else
                    $datos['mensaje']='Error inesperado';
            }
        }else
        {
            if($validar==3)
                   $datos['mensaje']='Error en BD';
            else
                $datos['mensaje']='Código de municipio inválido';    
        }
    }else
    {
        if($validar==3)
               $datos['mensaje']='Error en BD';
        else
            $datos['mensaje']='El estado no existe';    
    }
}

echo json_encode($datos);