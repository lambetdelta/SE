<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$form=array();
$datos=array();
$dato['mensaje']='Error en envío';
$dato['respuesta']='0';
if (isset($_POST['form'],$_POST['no_control'],$_POST['registro']))
{
    parse_str($_POST['form'],$form);
    if(is_numeric($_POST['no_control']))
    {
        $form=anti_xss($form);
        $validar_carrera=validarCarrera($form['carrera'], $mysqli);
        $validar_especialidad=validarEspecialidad($form['especialidad'], $mysqli);
        $fecha_inicio=validarFecha($form['fecha_inicio']);
        $fecha_fin=validarFecha($form['fecha_fin']);
            if($validar_carrera==1){
                if($validar_especialidad==1){
                    if($fecha_inicio==1){
                        if($fecha_fin==1){
                            if(strlen($form['titulado'])==2){
                                $resul=actualizar_dt_academicos($mysqli,$_POST['no_control'],$form['fecha_inicio'],$form['fecha_fin'],$form['carrera'],$form['especialidad'],$_POST['registro'],$form['titulado']);
                                if($resul==1)
                                {   
                                    $dato['respuesta']='1';
                                    $dato['mensaje']='EXITO';
                                }
                                else
                                    $dato['mensaje']='Error en guardado';
                            }else
                                $dato['mensaje']='Campo de titulación no válido';
                        }else
                            $dato['mensaje']='fecha no válida';
                    }else
                    $dato['mensaje']='fecha no válida';
                }else
                    $dato['mensaje']='Especialidad no válida';
            }else{
                $dato['mensaje']='Carrera no válida';
            }
        if(($validar_carrera==3)||($validar_especialidad==3))
            $dato['mensaje']='Error en BD';
    }
}

echo json_encode($dato);