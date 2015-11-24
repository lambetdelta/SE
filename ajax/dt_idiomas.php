<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$registros=dt_idiomas($mysqli,$_POST['no_control']);//funcion para extraer los datos de la consulta
        if($registros===FALSE)
            echo 'ERROR EN LA BD TRATA EN OTRO MOMENTO';
        else{
            echo'<p><h1>Idiomas<img id="agregar_idioma"  style="left:30%;" src="Imagenes/agregar.png"  title="AGREGAR IDIOMA" class="agregar_carrera"/></h1></p>';
            $num=$registros->num_rows;//verificar si hay registros
            if ($num>0){ 
                echo '<div class="table-responsive" >';
                echo'<table style="width:100%;" class="table table-hover table-condensed table-responsive">';
                echo'<thead>
                    <tr>
                        <th class="tb">Idioma</th>
                        <th class="tb">Habla</th>
                        <th class="tb">Lectura Escritura</th>
                    </tr>
                            </thead>';
                while($fila=$registros->fetch_assoc()){///mostrar cada registro en su div individual
                $resultado=nombre_idioma($fila['codigo_idiomafk'],$mysqli);
                $idioma=$resultado->fetch_assoc();
                echo '<tr style="border:hidden">';
                echo'<td class="tb"><b>'.$idioma['nombre'].'</b></td>';
                echo'<td class="tb"><b>'.$fila['porcentaje_habla'].'%</b></td>';
                echo'<td class="tb"><b>'.$fila['porcentaje_lec_escr'].'%</b></td>';
                echo'<td class="tb"><img id="'.$fila['id_consecutivo'].'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar_idioma"/></td>';
                echo '</tr>';
            }//fin de while
            echo'</table>';
            echo '</div>';
            }else//fin de if num	
                echo'<p>SIN REGISTROS POR EL MOMENTO AGREGUE SU IDIOMA</p></p>';
        }
}else//fin de if
    echo 'ERROR TRATA MÁS TARDE;';	

