<?php 
include_once '../includes/functions_adm.php';
include_once '../includes/conexion-bd-adm.php';
$datos=array();
$datos['mensaje']='Error en envío';
$datos['respuesta']='0';
if (isset($_POST['no_adm']))
{
    if(is_numeric($_POST['no_adm']))
    {
        $validar_adm=  validar_adm($mysqli, $_POST['no_adm']);
        if($validar_adm==1){
            $res=borrar_adm($mysqli,$_POST['no_adm']);
            if($res==1)
            {
                $datos['mensaje']='bien';
                $datos['respuesta']='1';
            }
            else
                if($res==3)
                    $datos['mensaje']='Error en bd';
                else
                    $datos['mensaje']='Error en ejecución';//error en guardado
        }else {
            if($res==3)
                    $datos['mensaje']='Error en bd';
                else
                    $datos['mensaje']='Error en identificador de administrador ';//error en guardado
        } 
    
    }
}


echo json_encode($datos);
