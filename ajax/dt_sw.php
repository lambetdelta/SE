<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
if (isset ($_POST['no_control'])){
	$registros=dt_sw($mysqli,$_POST['no_control']);//funcion para extraer los datos de la consulta
	if($registros==FALSE)
            echo 'ERROR EN BD TARTA EN OTRO MOMENTO';
        else{
            echo'<h1>Paquetes de Software<img id="agregar_sw" style="left:70%;"  src="Imagenes/agregar.png"  title="AGREGAR SOFTWARE" class="agregar_carrera" /></h1></h1>';
            $num=$registros->num_rows;//verificar si hay registros
            if ($num>0){
                    echo '<h2 style="text-align:center">Nombre</h2>';
                            echo '<div class="table-responsive">';
                            echo'<table style="width:100%;border:none; margin-bottom:55px" class="table table-hover table-condensed table-responsive" >'; 
                            while($fila=$registros->fetch_assoc()){///mostrar cada registro en su div individual
                            echo '<tr style="border:hidden">';
                            echo'<td class="td_sw"><b>'.$fila['nombre_sw'].'</b></td>';
                            echo'<td class="td_sw"><img id="'.$fila['id_consecutivo'].'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar_sw"/></td>';
                            echo '</tr>';
                    }//fin de while
                    echo'</table>';
                    echo '</div>';
            }else//fin de if num
            {	
            echo'<p>SIN REGISTROS POR EL MOMENTO AGREGUE SOFTWARE QUE UTILICE</p></p>';
            }          
        }   
}else//fin de if
    echo 'ERROR TRATA MÁS TARDE;';

?>