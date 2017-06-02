<?php 
include_once '../includes/db_connect.php';
include '../includes/functions.php';
$datos=array();
sleep(2);
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
if(isset($_POST["elegido"])){
    $id_estadofk=is_numeric($_POST["elegido"]) ? $_POST['elegido'] : 0;
    $query='select codigo_municipio,nombre from municipio where codigo_estadofk='.$id_estadofk;
    $stmt=$mysqli->query($query);
    if($stmt->num_rows > 0) {
        $datos['respuesta']='1';
        $datos['mensaje']='Bien';
        while ($fila=mysqli_fetch_array($stmt))
                $datos['municipio'][]=$fila;

    }  
    else 
        $datos['mensaje']='Error en carga de datos';
    
    
}

echo json_encode($datos);