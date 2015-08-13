<?php 
include_once '../includes/db_connect.php';
sleep(1);
$codigo_carrera=$_POST["elegido"];
$consulta="select * from especialidad where codigo_carrerafk='$codigo_carrera'";
	       if($resultado=$mysqli->query($consulta)){
			   if($resultado->num_rows==0)
			   echo '<option value="1">No disponible trate despues</option>';
			   else
			 while ($fila=mysqli_fetch_array($resultado)){
			   echo "<option value='".$fila['codigo_especialidad']."'>".$fila['nombre']."</option>";
			   }   
			   }
		   
?>