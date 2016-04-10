<?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

$form=array();
$datos=array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío';
if (isset($_POST['form'],$_POST['no_control']))
{
    parse_str($_POST['form'],$form);
    $form=anti_xss($form);
    if(is_numeric($_POST['no_control']))
    {
        $validar_idioma=validarIdioma($form['idiomas'], $mysqli);
        if($validar_idioma==1){
            if((is_numeric($form['porcentaje_habla']))&&(is_numeric($form['porcentaje_habla']))){
                $contar=contar_idioma($mysqli,$_POST['no_control']);
                if($contar==0)
                {
                    if(guardar_idioma($mysqli,$_POST['no_control'],$form['porcentaje_habla'],$form['porcentaje_lec'],$form['idiomas']))
                    {
                        $datos['respuesta']='1';
                        $datos['mensaje']='Bien';  
                    }
                    else
                        $datos['mensaje']='Error';
                }
                else
                   $datos['respuesta']='3';
            }else
            $datos['mensaje']='Porcentaje  inválido';
        }else
            $datos['mensaje']='Idioma inválido';
        if($validar_idioma==FALSE){
            $datos['respuesta']='0';
            $datos['mensaje']='ERROR EN BD';}
    }
}

echo json_encode($datos);