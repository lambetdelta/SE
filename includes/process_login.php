<?php
include 'db_connect.php';
include 'functions.php';
if($mysqli==FALSE){
    header('Location: ../error_bd.php');
}else{ 
sec_session_start(); // manera personalizada segura de iniciar sesión PHP.
if (isset($_POST['No_control'], $_POST['p'])) {
    $N_control = $_POST['No_control'];
    $password = $_POST['p']; // La contraseña con hash
    if($mysqli->connect_errno){
        header('Location: ../error_bd.php');
    }else{
        $login=login($N_control, $password, $mysqli);
        if ($login == 1) {
            // Inicio de sesión exitosa    
            if (primer_login($N_control,$mysqli)==true){
                header('Location: ../Bienvenido.php');}
            else{ 
                header('Location: ../perfil.php');}	
        }elseif( $login == 3 ){
            // Inicio  no exitosa
            $_SESSION['mensage']='Has sobrepasado los lo intentos de inicio de sesión, tendras que esperar 3 horas para iniciar sesión de nuevo';
            header('Location: ../mensage.php');
        }elseif( $login == 'NO_EXIST' ){
            // Inicio  no exitosa
            $_SESSION['mensage']='No estás aun registrado en el sistema, ponte en contacto con tu Tecnológico en el área de seguimiento de egresados para que te registren';
            header('Location: ../mensage.php');
        }else
            header('Location: ../error.php');

    }
} else {
    // Las variables POST correctas no se enviaron a esta página.
    header('Location: ../error.php');
}
}
