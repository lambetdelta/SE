<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
echo '<option value="1">Idioma</option>';
$consulta="select * from idioma";
if($resultado=$mysqli->query($consulta)){
	if($resultado->num_rows==0)
		echo '<option value="1">No disponible trate despues</option>';
	else
		while ($fila=$resultado->fetch_assoc()){
			echo '<option value="'.$fila['codigo_idioma'].'">'.$fila['nombre'].'</option>';
			}   
}else
echo 'ERROR';
?>