<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start(); // manera personalizada segura de iniciar sesión PHP.
 
if (isset($_POST['No_control'], $_POST['p'])) {
    $N_control = $_POST['No_control'];
    $password = $_POST['p']; // La contraseña con hash
 
    if (login($N_control, $password, $mysqli) == true) {
        // Inicio de sesión exitosa
     if  (primer_login($N_control,$mysqli)==true){
	  	header('Location: ../Bienvenido.php');}
	 else{ 
	  header('Location: ../perfil.php');}	
    } else {
        // Inicio de no exitosa
        header('Location: ../error.php');
    }
} else {
    // Las variables POST correctas no se enviaron a esta página.
    echo 'Solicitud no valida';
}
?>