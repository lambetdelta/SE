<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$no_control=$_POST['no_control'];
	$registros=dt_empresa($mysqli,$no_control);//funcion para extraer los datos de la consulta
	echo '<h1> DATOS DE LA EMPRESA´S</h1>';
	echo '<img id="agregar_empresa" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/></p>';
	$num=$registros->num_rows;//verificar si hay registros previos
	if ($num>0){ 
	while($fila=$registros->fetch_assoc()){///mostrar cada registro en su div individual
		echo'<div class="row">;';
		echo'<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
		echo '<div class="div_dt_empresa_Ajax" id="div_empresa'.$fila['codigo_empresa'].'">';
		echo '<p><img id="img_editar_empresa'.$fila['codigo_empresa'].'" src="Imagenes/editar.png"  title="EDITAR" class="editar_empresa"/><img id="img_editar_empresa'.$fila['codigo_empresa'].'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="elimnar_empresa"/></p>';
		echo '<p><img id="img_empresa'.$fila['codigo_empresa'].'" src="Imagenes/empresa.png" class="img_empresa visible-lg visible-md"/>';
		echo "EMPRESA:<b>".$fila['nombre']."</b></br>";
		echo "GIRO:<b>".$fila['giro']."</b></br>";
		echo "WEB:<b>".$fila['web']."</b></br>";
		echo "PUESTO:<b>".$fila['puesto']."</b></br>";
		echo "INGRESO:<b>".$fila['año_ingreso']."</b></p>";
		echo '</div>';
		echo '</div>';
	echo '</div>';
	}//fin de while
	}else//fin de if num
	{	
	echo'<p>SIN REGISTROS POR EL MOMENTO AGREGUE SU EMPRESA</p>';

	}}else//fin de if
echo 'ERROR TRATA MÁS TARDE;';	
?>