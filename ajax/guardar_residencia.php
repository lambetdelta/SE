<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

$form=array();
sleep(3);
$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
if (isset($_POST['form'],$_POST['no_control'])){
	parse_str($_POST['form'],$form);
		if(actualizar_residencia($mysqli,$_POST['no_control'],$form['residencia'])){
			$mensaje = 'EXITO';
			$respuesta = 'done';
			}//exito
		else{
			$mensaje = 'ERROR ';
			}//error en la actualización
}else
	$mensaje = 'ERROR RECEPCIÓN DE DATOS';
	$salidaJson = array("respuesta" => $respuesta,
					"mensaje" => $mensaje);
echo json_encode($salidaJson);
?>