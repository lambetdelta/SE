<?php 
include '../includes/db_connect.php';

$datos=array();
$datos['respuesta']='0';
$datos['Mensaje']='Error al cargar';
$consulta='select codigo_estado, nombre from estado where codigo_estado!="vacio"';
if($resultado=$mysqli->query($consulta))
{
    $datos['respuesta']='1';
    while ($fila=$resultado->fetch_assoc())
    $datos['estados'][]=$fila;
}

echo json_encode($datos);