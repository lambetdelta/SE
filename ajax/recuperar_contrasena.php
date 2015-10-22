<?php
include '../includes/db_connect.php';
include '../includes/function_ext.php';

    $mensaje='Falla en el envio de datos';
    $respuesta='error';
    if(isset($_POST['no_control'],$_POST['x'],$_POST['p'])){
       $no_control=  anti_xss_cad($_POST['no_control']);
       $password=  anti_xss_cad($_POST['p']);
       $password_confirmacion=anti_xss_cad($_POST['x']);
       if(is_numeric($no_control)){
           if(strlen($password)==128 and strlen($password_confirmacion)==128)//verificar longitud de pass recibido
           {
                $mysqli->autocommit(FALSE);
                if(nuevo_pass_recuperacion($no_control, $password, $mysqli)){
                    $mensaje='Nueva contraseña agregada, en el futuro sé más cuidadoso por favor';
                    $respuesta='hecho';
                    $mysqli->commit();
                }else
                {
                     $mysqli->rollback();
                     $mensaje='Falla en la actualización intente en otro momento';
                     $respuesta='error';   
                }
        
           }else
               $mensaje='Error envío de contraseña ';
       }else
           $mensaje='No:control inválido';
       
    }
    $salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
    echo json_encode($salidaJson);


