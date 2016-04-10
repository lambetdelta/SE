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
            if(is_numeric($form['no_adm'])){
                $validar_adm=  validar_adm($mysqli, $form['no_adm']);
                if($validar_adm==1){
                    $res=  editar_adm($mysqli,$nombre,$form['pass'],$form['no_adm']);
                    if($res==1)
                    {
                        $mensaje = 'Exito';
                        $respuesta = '1';
                    }//exito
                    else
                        if($res==3)
                            $mensaje = 'Fallo en la bl';
                        else
                            $mensaje = 'Error inesperado';
                }else
                    if($res==3)
                            $mensaje = 'Fallo en la b';
                        else
                            $mensaje = 'Identificador de administrador inválido';
                    
            }else
                $mensaje = 'Identificador de administrador inválido';
        }else
            if($validar_nombre==3)
                $mensaje = 'Fallo en la ';
            else
                $mensaje = 'Nombre de usuario en uso, utilice otro';
    }
    else 
        $mensaje = 'ERROR';
}
$salidaJson = array('respuesta' => $respuesta,'mensaje' => $mensaje);
echo json_encode($salidaJson);
