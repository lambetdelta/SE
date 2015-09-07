<?php 
include_once '../includes/db_connect.php';
sleep(1);
$id_estadofk=$_POST["elegido"];
$stmt=$mysqli->prepare('select * from municipio where codigo_estadofk=?');
$stmt->bind_param('i',$id_estadofk);
$stmt->execute();
$resultado=$stmt->get_result();
    while ($fila=mysqli_fetch_array($resultado))
        echo "<option value='".$fila['codigo_municipio']."'>".$fila['nombre']."</option>";

		   
?>