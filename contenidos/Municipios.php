<?php 
include_once '../includes/db_connect.php';
$datos=array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
if(isset($_POST["elegido"])){
    $id_estadofk=$_POST["elegido"];
    $stmt=$mysqli->prepare('select codigo_municipio,nombre from municipio where codigo_estadofk=?');
    $stmt->bind_param('s',$id_estadofk);
    if($stmt->execute()){
    $resultado=$stmt->get_result();
        $datos['respuesta']='1';
        $datos['mensaje']='Bien';
        while ($fila=mysqli_fetch_array($resultado))
                $datos['municipio'][]=$fila;

    }  
    else 
        $datos['mensaje']='Error en carga de datos';
    
    
}

echo json_encode($datos);