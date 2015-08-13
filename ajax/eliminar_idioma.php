<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset($_POST['registro'],$_POST['no_control'])){
	if(borrar_idioma($mysqli,$_POST['no_control'],$_POST['registro'])){
		echo "1";}//exito
	else
		echo "0";//error en guardado
}else
		echo "2";//error con el formulario enviado
?>