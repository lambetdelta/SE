<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$no_control=$_POST['no_control'];
	$registros=dt_social($mysqli,$no_control);//funcion para extraer los datos de la consulta
	if($registros==FALSE)
            echo 'ERROR EN BD TRATA EN OTRO MOMENTO';
        else{
            echo'<h1>ASOCIACIONES SOCIALES</h1>';
            echo '<img id="agregar_social" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS ACTIVIDADES SOCIALES" class="agregar_carrera"/>';
            $num=$registros->num_rows;//verificar si hay registros previos
            if ($num>0){ 
                while($fila=$registros->fetch_assoc()){///mostrar cada registro en su div individual
                        echo'<div class="row">';
                        echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="div_social'.$fila['id_consecutivo'].'">';
                        echo '<p><img id="img_eliminar_social'.$fila['id_consecutivo'].'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="elimnar_empresa" style="margin-left:30%"/></p>';
                        echo "<p>NOMBRE:<b>".$fila['nombre']."</b></p>";
                        echo "<p>TIPO:<b>".$fila['tipo']."</b><p>";
                        echo '</div>';
                        echo '</div>';
                }//fin de while
            }else//fin de if num	
                echo'<br><p>SIN REGISTROS POR EL MOMENTO AGREGUE UNA ACTIVIDAD SOCIAL</p>'; 
        }
}else//fin de if
    echo 'ERROR TRATA MÁS TARDE;';	
?>