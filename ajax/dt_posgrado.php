
<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$no_control=$_POST['no_control'];
	$registros=dt_posgrado($mysqli,$no_control);//funcion para extraer los datos de la consulta
	echo'<p><h1>Datos de Posgrado</h1><img id="agregar_posgrado"  src="Imagenes/agregar.png"  title="AGREGAR POSGRADO" class="agregar_carrera"/></p>';
	$num=$registros->num_rows;//verificar si hay registros 
	if ($num>0){ 
	while($fila=$registros->fetch_assoc()){///mostrar cada registro en su div individual
		echo '<div class="div_carrera" id="div_posgrado'.$fila['id_posgrado'].'">';
		echo "<p>POSGRADO:<b>".$fila['nombre']."</b>";
		echo '<img id="img_posgrado_borrar'.$fila['id_posgrado'].'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar"/></p>';
		echo "<p>Escuela:<b>".$fila['escuela']."</b></p>";
		echo "<p>Titulado:<b>".$fila['titulado']."</b></p>";
		echo "<p>Tipo:<b>".$fila['posgrado']."</b></p>";
		echo '</div>';
	}//fin de while
	}else//fin de if num
	{	
	echo'<p>SIN REGISTROS POR EL MOMENTO AGREGUE UN POSGRADO</p>';

	}}else//fin de if
echo 'ERROR TRATA MÁS TARDE;';	
?>