<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$datos=array();
$datos['respuesta']='0';
$datos['Mensaje']='Error al cargar';
if(isset($_POST["elegido"])){
    $codigo_carrera=anti_xss_cad($_POST["elegido"]);
    $consulta="select codigo_especialidad,nombre from especialidad where codigo_carrerafk='$codigo_carrera'";
    if($resultado=$mysqli->query($consulta))
    {
        $datos['respuesta']='1';
        if($resultado->num_rows>0){
            while ($fila=$resultado->fetch_assoc())
            $datos['especialidad'][]=$fila;
            
        }else{
           $datos['especialidad'][]=array('codigo_especialidad'=>'0','nombre'=>'Sin registros'); 
        }
    }
}
echo json_encode($datos);