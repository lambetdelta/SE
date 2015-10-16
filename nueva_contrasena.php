<?php
include '/includes/db_connect.php';

$token = $_GET['token'];
$no_control = $_GET['no_control']; 
$sql = "SELECT * FROM reseteo_contrasena WHERE token = '$token'";
$resultado = $mysqli->query($sql);
 
if( $resultado->num_rows > 0 ){
   $usuario = $resultado->fetch_assoc();
   if( sha1($usuario['no_controlfk']) == $no_control ){
       echo 'hola';
   }  else {
       echo 'mal2';    
   }

}  else {
    
    echo 'mal';}

