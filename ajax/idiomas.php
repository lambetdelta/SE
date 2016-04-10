<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';
$datos=array();
$datos['respuesta']='0';
$datos['Mensaje']='Error al cargar';
$consulta="select codigo_idioma,nombre from idioma";
if($resultado=$mysqli->query($consulta))
{
    $datos['respuesta']='1';
    while ($fila=$resultado->fetch_assoc())
    $datos['idioma'][]=$fila;
}

echo json_encode($datos);