<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

sleep(3);//guardar datos academicos 
$form=array();
if (isset($_POST['form'],$_POST['no_control'])){
	parse_str($_POST['form'],$form);
	if(!contar_idioma($mysqli,$_POST['no_control']))
	{
		if(guardar_idioma($mysqli,$_POST['no_control'],$form['porcentaje_habla'],$form['porcentaje_lec'],$form['idiomas'])){
			echo "1";}//exito
		else
			echo "0";//error en guardado
	}
	else
	echo "3";//error demaciados registros
}else
	echo "2";//error con el formulario enviado
?>