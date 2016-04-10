<?php 
include '../includes/db_connect.php';

$datos=array();
$datos['respuesta']='0';
$datos['Mensaje']='Error al cargar';
$consulta="select codigo_carrera,nombre from carrera";
if($resultado=$mysqli->query($consulta))
{
    $datos['respuesta']='1';
    while ($fila=$resultado->fetch_assoc())
    $datos['carrera'][]=$fila;
}

echo json_encode($datos);