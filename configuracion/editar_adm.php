<?php
/* Cualquier duda repecto al código o en que diablos estaba pensando cuando lo hice :) enviar un correo 
 *  con el asunto SE a la siguiente direccion lambetdelta@hotmail.com con el  Ing. Osvaldo Uriel Garcia Gomez*/ 
include "../includes/conexion-bd-adm.php";
//contraseña  del administrador 
$contraseña='ITTJ10940256_10940255!?!';//solo necesita cambiar esta parte, nada más  
$contraseña=  hash('sha512', $contraseña);
$salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));//obtener una salt aleatorio
$password=hash('sha512',$contraseña.$salt);//
$query='update  datos_administrador set pass=?, salt=? where nombre="administrador"';
if($query=$mysqli->prepare($query)){
            $query->bind_param('ss',$password,$salt);
            if($query->execute()){
                if($query->affected_rows>0)
                    echo 1;
                else
                    echo 2;
            }else
                echo 3;
    }else
        echo 3;