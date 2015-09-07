<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
if (isset ($_POST['no_control'],$_POST['empresa']))
{
    $no_control=$_POST['no_control'];
    if(is_numeric($_POST['no_control']))
    {    
        $registros=all_dt_empresa($mysqli,$no_control,$_POST['empresa']);//funcion para extraer los datos de la consulta
        while($fila=$registros->fetch_assoc())
        {///mostrar cada registro en su div individual
            $estado_municipio=nombre_estado_municipio($fila['codigo_estadofk'],$fila['codigo_municipiofk'],$mysqli);
            echo '<h1 style="text-align:center; font-size:22px;">DATOS DE LA EMPRESA A EDITAR</h1>';
            echo'<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
            echo "<p>EMPRESA:<b>".$fila['nombre']."</b></p>";
            echo "<p>GIRO:<b>".$fila['giro']."</b></p>";
            echo "<p>PUESTO:<b>".$fila['puesto']."</b></p>";
            echo "<p>INGRESO:<b>".$fila['año_ingreso']."</b></p>";
            echo "<p>JEFE:<b>".$fila['nombre_jefe']."</b></p>";
            echo '<h1 style="text-align:center;font-size:22px;">DATOS BÁSICOS</h1>';
            echo "<p>RAZÓN SOCIAL:<b>".$fila['razon_social']."</b>  ORGANISMO:<b>".$fila['organismo']."</b></p>";
            echo "<p>TELEFONO:<b>".$fila['telefono']."</b></p>";
            echo "<p>EMAIL:<b>".$fila['email']."</b></p>";
            echo "<p>WEB:<b>".$fila['web']."</b></p>";
            echo '<h1 style="text-align:center;font-size:22px;">BÚSQUEDA</h1>';
            echo "<p>MEDIO BÚSQUEDA:<b>".$fila['medio_busqueda']."</b></p> <p>TIEMPO DE BÚSQUEDA:<b>".$fila['tiempo_busqueda']."</b></p>";
            echo'</div>';
            echo'<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
            echo '<h1 style="text-align:center;font-size:22px;">DOMICILIO</h1>';
            echo "<p> Municipio: <b>".$estado_municipio['municipio']."</b></p>";
            echo "<p> Estado:<b> ".$estado_municipio['nombre']."</b></p>";
            echo '<h1 style="text-align:center;font-size:22px;">REQUISITOS</h1>';
            $requisitos=all_requisitos_empresa($mysqli,$no_control,$_POST['empresa']);
            while($req=$requisitos->fetch_assoc())
                echo "<p><b> ".$req['requisito']."</b></p>";
            echo'</div>';
        }//fin de while
    }
    else
        echo'2';
}
else//fin de if
    echo 'ERROR TRATA MÁS TARDE;';	
?>