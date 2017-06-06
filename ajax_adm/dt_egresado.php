<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=array();
if(isset($_POST['no_control'])){
    if(is_numeric($_POST['no_control'])){
        $resultado=  dt_egresado($_POST['no_control'], $mysqli);
        if($resultado==FALSE){
            $datos['mensage']='ERROR EN BD';
            $datos['resultado']='0';}
        else{
            $datos['resultado']='1';
            $fila=$resultado->fetch_assoc())  
            $datos['egresado']=array('nombre'=>$fila['nombre'],'apellido_p'=>$fila['apellido_p'],'apellido_m'=>$fila['apellido_m'],
            'curp'=>$fila['curp'],'genero'=>$fila['genero'],'telefono'=>$fila['telefono'],
            'email'=>$fila['email'],'fecha_nacimiento'=>$fila['fecha_nacimiento'],
            'calle'=>$fila['calle'],'numero_casa'=>$fila['numero_casa'],'cp'=>$fila['cp'],
            'estado'=>$fila['estado'],'municipio'=>$fila['municipio']);
        }
    }else{
        $datos['mensage']='ERROR EN DATOS ENVIADOS';
        $datos['resultado']='0';}
}else{
    $datos['mensage']='ERROR EN DATOS ENVIADOS';
    $datos['resultado']='0';}
echo json_encode($datos);
    

    
