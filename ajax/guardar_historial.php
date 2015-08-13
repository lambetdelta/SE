<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

sleep(3);//guardar datos academicos 
$form=array();
if (isset($_POST['form'],$_POST['no_control'])){
	parse_str($_POST['form'],$form);
		if(guardar_historial_nuev($mysqli,$_POST['no_control'],$form['nombre'],$form['tel'],$form['web'],$form['email'])){
			echo "1";}//exito
		else
			echo "0";//error en guardado
}else
	echo "2";//error con el formulario enviado
?>