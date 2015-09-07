<?php 
include_once '../includes/db_connect.php';


$consulta="select * from estado";
echo '<option value="1">ESTADO</option>';
if($resultado=$mysqli->query($consulta))
{
    while ($fila=$resultado->fetch_assoc())
    echo '<option value="'.$fila['codigo_estado'].'">'.$fila['nombre'].'</option>';
}
		   
?>