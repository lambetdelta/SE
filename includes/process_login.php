<?php
include 'db_connect.php';
include 'functions.php';
if($mysqli==FALSE){
    header('Location: ../error_bd.php');
}else{ 
sec_session_start(); // manera personalizada segura de iniciar sesión PHP.
session_start(); 
if (isset($_POST['No_control'], $_POST['p'])) {
    $N_control = $_POST['No_control'];
    $password = $_POST['p']; // La contraseña con hash
    if($mysqli->connect_errno){
        header('Location: ../error_bd.php');
    }else{
        $login=login($N_control, $password, $mysqli);
        if ($login == 1) {
            // Inicio de sesión exitosa    
         if  (primer_login($N_control,$mysqli)==true){
                    header('Location: ../Bienvenido.php');}
             else{ 
              header('Location: ../perfil.php');}	
        } else {
            // Inicio  no exitosa
            if($login==3){
                $_SESSION['mensage']='Has sobrepasado los lo intentos de incio de sesión, tendras que esperar 3 horas para iniciar sesión de nuevo';
                header('Location: ../mensage.php');
            }else
            header('Location: ../error.php');
        }

    }
} else {
    // Las variables POST correctas no se enviaron a esta página.
    header('Location: ../error.php');
}
}
