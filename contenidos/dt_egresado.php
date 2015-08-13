<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$no_control=$_POST['no_control'];
	$datos=datos_egresado($no_control,$mysqli);
	$estado_municipio=nombre_estado_municipio($datos['codigo_estadofk'],$datos['codigo_municipiofk'],$mysqli);
	echo '<img src="Imagenes/editar.png" class="img-responsive editar" id="img_editar" title="EDITAR PERFIL"/>';
	echo 'Nombre:<b>'.$datos['nombre'].'</b><br/>';
	echo "Apellido Paterno:<b>".$datos['apellido_p']."</b><br/>";
	echo "Apellido Materno:<b>".$datos['apellido_m']."</b></br>";
	echo "CURP:<b>".$datos['curp']."</b><br/>";
	echo "Telefono:<b>".$datos['telefono']."</b></br>";
	echo "Email:<b>".$datos['email']."</b></br>";
	echo "Fecha nacimiento:<b>".$datos['fecha_nacimiento']."</b></br>";
	echo '<h1 class="domicilio">Domicilio</h1>';
	echo "Calle:<b>".$datos['calle']."</b></br>";
	echo "No:<b>".$datos['numero_casa']."</b></br>";
	echo "Municipio: <b>".$estado_municipio['municipio']."</b></br>";
	echo "Estado:<b> ".$estado_municipio['nombre']."</b></br>";	 
			   
}
else
echo 'ERROR EN ENVIO DE DATOS TRATE OTRO MOMENTO;';
?>