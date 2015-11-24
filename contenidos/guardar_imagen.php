<?php
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

//Leemos los datos del usuario
$id = $_POST["id"];
//NOTA: La imagen viene en Base 64 (porque así la enviamos desde consultar.html)
$img = $_POST["imagen"];
  
//escapamos antes de armar la consulta
$id = mysqli_escape_string($mysqli, $id);
$img = mysqli_escape_string($mysqli, $img);
 
//Si el usuario no existe lo insertamos,
//y si ya existe lo actualizamos
$consulta_sql = "INSERT INTO foto_egresado(no_controlfk, imagen)\n". 
                "    VALUES ('$id', '$img')\n".
                "ON DUPLICATE KEY\n".
                "    UPDATE imagen = VALUES('$img')";
 
mysqli_query($mysqli, $consulta_sql) 
    or mostrar_error("Error al ejecutar la consulta:\n$consulta_sql.\n\n".
                      mysqli_errno($mysqli) . ": " . mysqli_error($mysqli));
 
 
//La respuesta en formato JSON...
$respuesta = array(
    'ok' => true
);
echo json_encode($respuesta);

?>