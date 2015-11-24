<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
if(isset($_POST['dato'],$_POST['limit'],$_POST['cantidad'])){
    $dato=  anti_xss_cad($_POST['dato']);
    $limit=  anti_xss_cad($_POST['limit']);
    $cantidad=  anti_xss_cad($_POST['cantidad']);
    $resultado=  buscar($dato, $mysqli,$limit,$cantidad);
    if($resultado==FALSE){
        $html='<div class="div-resultado">Sin coincidencias</div><div class="div-resultado" id="ver-todos"><p class="p-ver-todos">Ver todos...</p></div>';
        echo $html; 
    }  else {
        while ($fila=$resultado->fetch_assoc()){
            $html='<div id="div-resultado'.$fila['no_control'].'" class="div-resultado"><span class="span-no_control">'.$fila['no_control'].'</span>'
                    . '<div class="div-miniatura"><img src="fotos_egresados/'.$fila['imagen'].'" class="img-egresado"/>'.$fila['nombre'].' '.$fila['apellido_p'].' '.$fila['apellido_m'].'</div></div>';
            echo $html;
        }
        echo '<div class="div-resultado" id="ver-todos"><p class="p-ver-todos">Ver todos...</p></div>';
    }
}else
    echo 'ERROR ENVIO DATOS';
