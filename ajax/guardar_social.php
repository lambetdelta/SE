<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';


$datos=array();
$datos['mensaje']='Error en envío';
$datos['respuesta']='0';
if (isset($_POST['form'],$_POST['no_control']))
{
    if(is_numeric($_POST['no_control']))
    {
    parse_str($_POST['form'],$form);
    $form=anti_xss($form);
    if (validarSocial($form['tipo'])){
        if(strlen($form['nombre'])<=40){
            if(guardar_social($mysqli,$_POST['no_control'],$form['nombre'],$form['tipo']))
            {
                $datos['mensaje']='bien';
                $datos['respuesta']='1';
            }
            else
                $datos['mensaje']='Error en guardado';
        }else
            $datos['mensaje']='Campo nombre muy largo 40 caracteres máximo';
    }else
        $datos['mensaje']='Campo tipo de asociación inválido';
    }
}

echo json_encode($datos);