<?php
include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
sleep(3);    
    $resultado=  buscar_todos($mysqli);
    if($resultado==FALSE){
        $html='<div class="div-resultado">Sin coincidencias</div>';
        echo $html; 
    }  else {
        while ($fila=$resultado->fetch_assoc()){
            $html='<div id="div-resultado'.$fila['no_control'].'" class="div-resultado"><span class="span-no_control">'.$fila['no_control'].'</span>'
                    . '<div class="div-miniatura"><img src="fotos_egresados/'.$fila['imagen'].'" class="img-egresado"/>'.$fila['nombre'].' '.$fila['apellido_p'].' '.$fila['apellido_m'].'</div></div>';
            echo $html;
        }
  
    }

