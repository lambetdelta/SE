<?php 
include '../includes/functions_adm.php';
include '../includes/conexion-bd-adm.php';
$mensaje = 'ERROR FORMULARIO';
$respuesta = false;
$form=array();
if (isset($_POST['form']))
{
    parse_str($_POST['form'], $form);
    if(strlen($form['pass'])==128)
    {
        $nombre=anti_xss_cad($form['nombre']);
        $validar_nombre=  validar_nombre_adm($mysqli,$nombre);
        if($validar_nombre==1){
            $res=nuevo_adm($mysqli,$nombre,$form['pass']);
            if($res==1)
            {
                $mensaje = 'Exito';
                $respuesta = '1';
            }//exito
            else
                if($res==3)
                    $mensaje = 'Fallo en la bd';
                else
                    $mensaje = 'Error inesperado';
        }else
            if($validar_nombre==3)
                $mensaje = 'Fallo en la BD';
            else
                $mensaje = 'Nombre de usuario en uso, utilice otro';
    }
    else 
        $mensaje = 'ERROR';
}
$salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
echo json_encode($salidaJson);