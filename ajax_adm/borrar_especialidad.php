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
    $validar= validarCarrera_num($form['carrera'],$mysqli);
    if($validar==1){
        $validar=  validarEspecialidad($form['codigo'],$mysqli);
        if($validar==1){
            $res=borrar_especialidad($mysqli,$form['codigo']);
            if($res==1){
                $datos['respuesta']='1';
                $datos['mensaje']='Bien';
            }else{
                if($res==3)
                   $datos['mensaje']='Error en BD';
                else
                    $datos['mensaje']='Error inesperado';     
            }
        }else{
            if($validar==3)
               $datos['mensaje']='Error en BD';
            else
                $datos['mensaje']='El código de especialidad no existe';
        }
    }else
        if($validar==3)
           $datos['mensaje']='Error en BD';
        else
            $datos['mensaje']='El código de carrera no existe';
}

echo json_encode($datos);

