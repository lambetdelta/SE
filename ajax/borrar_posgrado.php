<?php 
include '../includes/functions.php';
include '../includes/db_connect.php';

sleep(3);
$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
if (isset($_POST['no_control'],$_POST['registro'])){
		if(borrar_posgrado($mysqli,$_POST['no_control'],$_POST['registro'])){
			$mensaje = 'EXITO';
			$respuesta = 'done';
			}//exito
		else{
			$mensaje = 'ERROR EN EL BORRADO';
			}//error en la actualización
}else
	$mensaje = 'ERROR RECEPCIÓN DE DATOS';
	$salidaJson = array('respuesta' => $respuesta,
					'mensaje' => $mensaje);
echo json_encode($salidaJson);
?>