<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

$form=array();
sleep(3);
if (isset($_POST['no_control'],$_POST['registro'])){
	$mysqli->autocommit(false);
	if(guardar_historial($mysqli,$_POST['no_control'],$_POST['registro'])){
		if(borrar_empresa($mysqli,$_POST['no_control'],$_POST['registro'])){
			$mysqli->commit();
			echo '1';
		}else{
			$mysqli->rollback();
			echo '3';
			}	
	}else{
		$mysqli->rollback();
		echo '3';
		}
}else
	echo "2";//error con el formulario enviado
	
	
?>