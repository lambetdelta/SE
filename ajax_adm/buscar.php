<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
if(isset($_POST['dato'])){
    $dato=  anti_xss_cad($_POST['dato']);
    $resultado=  buscar($dato, $mysqli);
    if($resultado==FALSE){
        $html='<div class="div-resultado">Sin coincidencias</div>';
        echo $html; 
    }  else {
        while ($fila=$resultado->fetch_assoc()){
            $html='<div class="div-resultado"><span>'.$fila['no_control'].'</span></div>';
            echo $html;
        }
    }
}else
    echo 'ERROR ENVIO DATOS';
