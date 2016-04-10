<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

$form = array();
$datos=array();
$dato['mensaje']='Error en envío';
$dato['respuesta']='0';
if (isset($_POST['form'], $_POST['no_control'])) 
{//guardar datos de egresado
    if(is_numeric($_POST['no_control']))
    {
        parse_str($_POST['form'], $form);
        $form=anti_xss($form);
        if(validarNombre($form['nombre'])){
            if(validarNombre($form['apellido_p'])){
                if(validarNombre($form['apellido_m'])){
                    if(validarTelefono($form['tel'])){
                        if(validarEmail($form['email'])){
                            if(is_numeric($form['cp'])){
                                if(validarFecha($form['fecha_nac'])){
                                    if(validarEstado($form['estado'], $mysqli)){
                                        if(validarMun($form['municipio'], $mysqli)){
                                            $resultado = actualizar_egresado($mysqli, $form['nombre'], $form['apellido_m'], $form['apellido_p'], $form['curp'], $form['genero'] ,$form['fecha_nac'], $form['tel'], $form['email'],$form['ciudad'],$form['colonia'],$form['calle'], $form['no_casa'], $form['cp'], $form['estado'], $form['municipio'], $_POST['no_control']);
                                            if($resultado==FALSE){
                                               $dato['mensaje']='Error en BD';  
                                            }  else {
                                               $dato['mensaje']='Completado'; 
                                               $dato['respuesta']='1';
                                            }
                                        }else
                                        $dato['mensaje']='Error en el campo municipio'; 
                                    }else
                                        $dato['mensaje']='Error en el campo estado'; 
                                }else
                                   $dato['mensaje']='Error en fecha de nacimiento  caracteres inválidos o exceden la longitud máxima';  
                            }else
                            $dato['mensaje']='Error en código postal  caracteres inválidos o exceden la longitud máxima';  
                        }else
                            $dato['mensaje']='Error en  email  caracteres inválidos o exceden la longitud máxima';  
                    }else
                      $dato['mensaje']='Error en  teléfono  caracteres inválidos o exceden la longitud máxima';   
                }
                else
                $dato['mensaje']='Error en  apellido materno  caracteres inválidos o exceden la longitud máxima';  
            }else
              $dato['mensaje']='Error en  apellido paterno  caracteres inválidos o exceden la longitud máxima';         
        } else {
          $dato['mensaje']='Error en  nombre  caracteres inválidos o exceden la longitud máxima';  
        }
    }

}
echo json_encode($dato);

?>