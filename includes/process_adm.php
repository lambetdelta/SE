<?php
include_once 'conexion-bd-adm.php';
include_once './functions.php';
if($mysqli==FALSE){//en caso de fallo en mysql
    header('Location: ../error_bd.php');
}else{ 
    sec_session_start(); // manera personalizada segura de iniciar sesión PHP.
    session_start(); 
    if (isset($_POST['usuario'],$_POST['p'])) {
        $Usuario = $_POST['usuario'];
        $Password = $_POST['p']; // La contraseña con hash
        $user=login_adm($Usuario, $Password, $mysqli);
        if ($user == 1) {
            // Inicio de sesión exitosa 
              header('Location: ../administrador.php');	
        } else {
            // Inicio de no exitosa
            if($login==3){
                $_SESSION['mensage']='Has sobrepasado los lo intentos de incio de sesión, tendras que esperar 3 horas para iniciar sesión de nuevo';
                header('Location: ../mensage.php');
            }else
            header('Location: ../error.php');
        }
    } else {
        // Las variables POST correctas no se enviaron a esta página.
        echo 'ERROR';
    }
}
