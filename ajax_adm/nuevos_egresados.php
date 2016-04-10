<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
$form=array();
    if(isset($_POST['form'],$_POST['cantidad'])){
        parse_str($_POST['form'],$form);
        if(validar_egresado($form)){
            if(is_numeric($_POST['cantidad'])){
                $x=1;
                $intentos=0;
                $datos['egresados']='';
                while($x<=$_POST['cantidad']){
                    $egresado=$form['no_control'.$x];
                    $resultado=nuevo_egresado($egresado, $mysqli);
                    if($resultado=='1'){
                        ++$intentos;
                    }else{
                        if($resultado=='3')
                            $egresado=$egresado.' ya registrado ';
                        $datos['egresados']=$egresado.' '.$datos['egresados'];   
                    }
                    ++$x;
                }
                --$x;
            if($intentos==$_POST['cantidad']){
                $datos['respuesta']='1';
                $datos['mensaje']='Bien';    
            }else{
                $datos['respuesta']='2';
                $datos['mensaje']='Los siguientes alumnos no se guardaron:';  
            }

            }else
             $datos['mensaje']='Cantidad de egresados inválida';   
        }else 
           $datos['mensaje']='No: de control inválido'; 

    }

echo json_encode($datos);