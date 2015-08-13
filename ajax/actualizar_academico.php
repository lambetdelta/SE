<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

$form=array();
sleep(3);
if (isset($_POST['form'],$_POST['no_control'],$_POST['registro'])){
	parse_str($_POST['form'],$form);
		if(actualizar_dt_academicos($mysqli,$_POST['no_control'],$form['fecha_inicio'],$form['fecha_fin'],$form['carrera'],$form['especialidad'],$_POST['registro'],$form['titulado'])){
			echo "1";}//exito
		else{
			echo "0";
			}//error en la actualización
}else
	echo "2";//error con el formulario enviado
?>