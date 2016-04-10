<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
$datos=array();
$datos['respuesta']='1';
$datos['mensage']='Error en envío de datos';
$escuela=  datos();
$datos['escuela']=array('director'=>$escuela[1],'fecha'=>$escuela[0],'cargo'=>$escuela[2],'direccion'=>$escuela[3],'tel'=>$escuela[4],'web'=>$escuela[6],'email'=>$escuela[5]);
echo json_encode($datos);


