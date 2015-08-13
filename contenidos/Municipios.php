<?php 
include_once '../includes/db_connect.php';
sleep(1);
$id_estadofk=$_POST["elegido"];
$consulta="select * from municipio where codigo_estadofk='$id_estadofk'";
	       if($resultado=$mysqli->query($consulta)){
			 while ($fila=mysqli_fetch_array($resultado)){
			   echo "<option value='".$fila['codigo_municipio']."'>".$fila['nombre']."</option>";
			   }   
			   }
		   
?>