<?php
include_once 'conexion-bd-adm.php';
include_once 'functions.php';
 
sec_session_start(); // manera personalizada segura de iniciar sesión PHP.
 
if (isset($_POST['usuario'],$_POST['p'])) {
    $Usuario = $_POST['usuario'];
    $Password = $_POST['p']; // La contraseña con hash
 
    if (login_adm($Usuario, $Password, $mysqli) == true) {
        // Inicio de sesión exitosa 
	  header('Location: ../administrador.php');	
    } else {
        // Inicio de no exitosa
        header('Location: ../error.php');
    }
} else {
    // Las variables POST correctas no se enviaron a esta página.
    echo 'ERROR';
}

