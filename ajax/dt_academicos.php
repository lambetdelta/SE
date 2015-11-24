<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$no_control=$_POST['no_control'];
	$registros=dt_academicos($mysqli,$no_control);//funcion para extraer los datos de la consult
        echo'<p><h1>Datos Académicos<img id="agregar_carrera"  src="Imagenes/agregar.png"  class="agregar_carrera" title="AGREGAR CARRERA Y ESPECIALIDAD" ></h1></p>';
	if ($registros===FALSE) 
            echo'ERROR EN LA BD TRATA EN OTRO MOMENTO';
        else{
            if ($registros->num_rows>0){ 
                while($fila=$registros->fetch_assoc()){///mostrar cada registro en su div individual
                        $carrera=nombre_carrera_especialidad($fila['codigo_carrerafk'],$fila['codigo_especialidadfk'],$mysqli);
                        echo '<div class="div_carrera" id="'.$fila['no_registro'].'">';
                        echo "<p>Carrera:<b>".$carrera['carrera']."</b>";
                        echo '<img id="'.$fila['no_registro'].'" src="Imagenes/editar.png"  title="EDITAR" class="editar_academico"/><img id="'.$fila['no_registro'].'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar"/></p>';
                        echo "<p>Titulado:<b>".$fila['titulado']."</b></p>";
                        echo "<p>Especialidad:<b>".$carrera['especialidad']."</b></p>";
                        echo "<p>Inicio:<b>".$fila['fecha_inicio']."</b></p>";
                        echo "<p>Finalización:<b>".$fila['fecha_fin']."</b></p>";
                        echo '</div>';
                    }//fin de while
            }else//fin de if num	
                echo'<p>SIN REGISTROS POR EL MOMENTO AGREGUE SU CARRERA</p>';
        }
        
}else//fin de if
    echo 'ERROR TRATA MÁS TARDE;';	