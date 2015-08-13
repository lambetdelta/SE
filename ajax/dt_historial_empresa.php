<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$no_control=$_POST['no_control'];
	$registros=dt_historial_empresarial($mysqli,$no_control);//funcion para extraer los datos de la consulta
	echo'<p><h1>EMPRESA´S</h1><br/>';
	echo '<img id="agregar_historial" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/></p>';
	$num=$registros->num_rows;//verificar si hay registros previos
	if ($num>0){ 
	while($fila=$registros->fetch_assoc()){///mostrar cada registro en su div individual
		echo'<div class="row">';
		echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div_dt_empresa_ajax" id="div_historial_empresa'.$fila['id_consecutivo'].'">';
		echo '<p><img id="img_historial_empresa'.$fila['id_consecutivo'].'" src="Imagenes/editar.png"  title="EDITAR" class="editar_empresa"/><img id="img_historial_empresa'.$fila['id_consecutivo'].'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="elimnar_empresa"/></p>';
		echo '<p><img id="img_empresa_historial'.$fila['id_consecutivo'].'" src="Imagenes/historial_empresa.png" class="img_empresa visible-lg visible-md"/>';
		echo "EMPRESA:<b>".$fila['nombre']."</b></br>";
		echo "WEB:<b>".$fila['web']."</b></br>";
		echo "TELEFONO:<b>".$fila['telefono']."</b></br>";
		echo "EMAIL:<b>".$fila['email']."</b></p>";
		echo '</div>';
		echo '</div>';
	}//fin de while
	}else//fin de if num
	{	
	echo'<br><p>SIN REGISTROS POR EL MOMENTO AGREGUE UN HISTORIAL DE SU CARRERA PROFESIONAL</p>';

	}}else//fin de if
echo 'ERROR TRATA MÁS TARDE;';	
?>