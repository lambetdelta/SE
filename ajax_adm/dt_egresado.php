<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
sleep(3);
$datos=array();
if(isset($_POST['no_control'])){
    if(is_numeric($_POST['no_control'])){
        $resultado=  dt_egresado($_POST['no_control'], $mysqli);
        if($resultado==FALSE){
            $datos['mensage']='ERROR EN BD';
            $datos['resultado']='0';}
        else{
            $datos['resultado']='1';
            while($fila=$resultado->fetch_assoc()){
                $estado_municipio=estado_municipio($fila['codigo_estadofk'], $fila['codigo_municipiofk'], $mysqli);
                if($estado_municipio==FALSE)
                    $estado_municipio=array('estado'=>'falla','municipio'=>'falla');    
                $datos['egresado']=array('nombre'=>$fila['nombre'],'apellido_p'=>$fila['apellido_p'],'apellido_m'=>$fila['apellido_m'],
                    'curp'=>$fila['curp'],'telefono'=>$fila['telefono'],
                    'email'=>$fila['email'],'fecha_nacimiento'=>$fila['fecha_nacimiento'],
                    'calle'=>$fila['calle'],'numero_casa'=>$fila['numero_casa'],
                    'estado'=>$estado_municipio['nombre'],'municipio'=>$estado_municipio['municipio']);
            
            }
            
        }
    }else{
        $datos['mensage']='ERROR EN DATOS ENVIADOS';
        $datos['resultado']='0';}
}else{
    $datos['mensage']='ERROR EN DATOS ENVIADOS';
    $datos['resultado']='0';}
echo json_encode($datos);
    

    
