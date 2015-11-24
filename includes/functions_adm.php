<?php

function anti_xss($form){//limpiar formularios recibidos 
        foreach ($form as &$valor):
            $valor=  strip_tags($valor);
            // General   
            $valor=str_replace("<","",$valor);   
            $valor=str_replace(">","",$valor);   
            $valor=str_replace("{","",$valor);   
            $valor=str_replace("}","",$valor);   
            $valor=str_replace("[","",$valor);   
            $valor=str_replace("]","",$valor);   
            $valor=str_replace("(","",$valor);   
            $valor=str_replace(")","",$valor);   
            $valor=str_replace("/","",$valor);   
            $valor=str_replace("\\","",$valor);   

            // PHP   

            $valor= str_replace("function" , "" , $valor);   
            $valor= str_replace("php" , "" , $valor);   
            $valor= str_replace("echo" , "" , $valor);   
            $valor= str_replace("print" , "" , $valor);   
            $valor= str_replace("return" , "" , $valor);   

            // HTML   

            $valor= str_replace("html" , "" , $valor);   
            $valor= str_replace("body" , "" , $valor);   
            $valor= str_replace("head" , "" , $valor);   

            // JS   

            $valor= str_replace("script" , "" , $valor);   

            // Ajax y Otros   

            $valor= str_replace("xml" , "" , $valor);   
            $valor= str_replace("version" , "" , $valor);   
            $valor= str_replace("encoding" , "" , $valor);   

            // CSS   

            $valor= str_replace("style" , "" , $valor); 
        endforeach;
        unset($valor);
        return $form;
}

function anti_xss_cad($cadena){//limpiar cadenas recibidas
            $valor=$cadena;
            $valor=  trim($valor);
            $valor=  strip_tags($valor);
            // General   
            $valor=str_replace("<","",$valor);   
            $valor=str_replace(">","",$valor);   
            $valor=str_replace("{","",$valor);   
            $valor=str_replace("}","",$valor);   
            $valor=str_replace("[","",$valor);   
            $valor=str_replace("]","",$valor);   
            $valor=str_replace("(","",$valor);   
            $valor=str_replace(")","",$valor);   
            $valor=str_replace("/","",$valor);   
            $valor=str_replace("\\","",$valor);   

            // PHP   

            $valor= str_replace("function" , "" , $valor);   
            $valor= str_replace("php" , "" , $valor);   
            $valor= str_replace("echo" , "" , $valor);   
            $valor= str_replace("print" , "" , $valor);   
            $valor= str_replace("return" , "" , $valor);   

            // HTML   

            $valor= str_replace("html" , "" , $valor);   
            $valor= str_replace("body" , "" , $valor);   
            $valor= str_replace("head" , "" , $valor);   

            // JS   

            $valor= str_replace("script" , "" , $valor);   

            // Ajax y Otros   

            $valor= str_replace("xml" , "" , $valor);   
            $valor= str_replace("version" , "" , $valor);   
            $valor= str_replace("encoding" , "" , $valor);   

            // CSS   

            $valor= str_replace("style" , "" , $valor); 
            return $valor;
}

function  buscar($dato,$mysqli,$limit,$cantidad){//busqueda general
    if(is_numeric($dato)){
        $resultado=buscar_no_control($dato, $mysqli,$limit,$cantidad);
        return $resultado;
    }  else {
        $resultado=  buscar_nombre($dato, $mysqli,$limit,$cantidad);
        return $resultado;
    }
}

function buscar_no_control($dato,$mysqli,$limit,$cantidad){
    $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where no_control like ?';
    if($limit==1)
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where no_control like ? limit '.$cantidad;
    if($query=$mysqli->prepare($sentencia))
        {
        $dato=$dato.'%';
        $query->bind_param('s',$dato);
        $query->execute();
        $resultado=$query->get_result();
        if($resultado->num_rows>0){
            $query->close();
            return $resultado;}
        else {
            $query->close();
            return FALSE;}
        }
    else
        return FALSE;  
}

function buscar_nombre($dato,$mysqli,$limit,$cantidad){
 $nombre=  explode(' ', $dato);
    if(count($nombre)==1){//secuencia un solo nombre
        $resultado=buscar_nombre_($nombre[0], $mysqli,$limit,$cantidad);
        if($resultado===FALSE){
            $resultado=  buscar_apellido_p($dato, $mysqli,$limit,$cantidad);
            return $resultado;
        }else
            return $resultado;
    }
    if(count($nombre)==2){
        $resultado=  buscar_nombre_incompleto($nombre[0], $nombre[1], $mysqli,$limit,$cantidad);//puede que busque en la siguiente secuencia nombre + primer apellido
        if($resultado==FALSE){
            $resultado=  buscar_nombre_($dato, $mysqli);//puede que busque en la secuencia primer nombre segundo nombre
            if($resultado==FALSE){
                $resultado=buscar_apellidos($nombre[0], $nombre[1], $mysqli);//busqueda por apellidos
                return $resultado;
            }                
        }
        else
            return $resultado;
    }
    if(count($nombre)>=3){//cuando el dato es un nombre que puede tenerla secuencia nombre apellido apellido, nombre nombre apellido, nombre nombre nombre , o mas combianciones con n nombres
        $nombre_completo=$nombre[0];
        for($i=1;$i<(count($nombre)-2);$i++) {
            $nombre_completo=$nombre_completo.' '.$nombre[$i];
        }
        $resultado=  buscar_nombre_completo($nombre_completo, $nombre[count($nombre)-2], $nombre[count($nombre)-1], $mysqli,$limit,$cantidad);     
        if($resultado===FALSE){
            $nombre_completo=$nombre[0].' '.$nombre[1];//extraer el primer nombre
            $resultado=  buscar_nombre_incompleto($nombre_completo, $nombre[2], $mysqli,$limit,$cantidad);//busca por medio de dos nombres y el primer apellido
            if($resultado===FALSE){
                $resultado=  buscar_nombre_($dato, $mysqli,$limit,$cantidad);//quizás tenga tres nombres o más, raro pero no imposible
                return $resultado;
            }  else {
                return $resultado;
            }
        }  else {
            return $resultado;
        }
    }
}

function buscar_nombre_($nombre,$mysqli,$limit,$cantidad){
    $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where nombre like ?';
    if($limit==1)
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where nombre like ? limit '.$cantidad;
    if($query=$mysqli->prepare($sentencia))
        {
        $nombre=$nombre.'%';
        $query->bind_param('s',$nombre);
        $query->execute();
        $resultado=$query->get_result();
        $query->close();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE; 
}
function buscar_nombre_incompleto($nombre,$apellido,$mysqli,$limit,$cantidad){
    $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( nombre like ? or apellido_p like ?)';
    if($limit==1)
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( nombre like ? or apellido_p like ?) LIMIT '.$cantidad;
    if($query=$mysqli->prepare($sentencia))
        {
        $nombre=$nombre.'%';
        $apellido=$apellido.'%';
        $query->bind_param('ss',$nombre,$apellido);
        $query->execute();
        $resultado=$query->get_result();
        $query->close();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE; 
}
function buscar_nombre_completo($nombre,$apellido_p,$apellido_m,$mysqli,$limit,$cantidad){
    $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( nombre like ? and apellido_p like ? and apellido_m like ?)';
    if($limit==1)
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( nombre like ? and apellido_p like ? and apellido_m like ?) LIMIT '.$cantidad;
    if($query=$mysqli->prepare($sentencia))
        {
        $apellido_m=$apellido_m.'%';
        $query->bind_param('sss',$nombre,$apellido_p,$apellido_m);
        $query->execute();
        $resultado=$query->get_result();
        $query->close();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE; 
}

function buscar_apellidos($apellido_p,$apellido_m,$mysqli,$limit,$cantidad){
   $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( apellido_p like ? or apellido_m like ?)';
    if($limit==1)
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( apellido_p like ? or apellido_m like ?) LIMIT '.$cantidad;
    if($query=$mysqli->prepare($sentencia))
        {
        $apellido_p=$apellido_p.'%';
        $apellido_m=$apellido_m.'%';
        $query->bind_param('ss',$apellido_p,$apellido_m);
        $query->execute();
        $resultado=$query->get_result();
        $query->close();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE;
}

function buscar_apellido_p($apellido_p,$mysqli,$limit,$cantidad){
    $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where apellido_p like ? ';
    if($limit==1)
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where apellido_p like ? LIMIT '.$cantidad;
   if($query=$mysqli->prepare($sentencia))
        {
        $apellido_p=$apellido_p.'%';
        $query->bind_param('s',$apellido_p);
        $query->execute();
        $resultado=$query->get_result();
        $query->close();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE;   
}

function buscar_todos($mysqli){
    try{
        $query='select no_control, nombre, apellido_p, apellido_m,imagen from datos_egresado';
        if($resultado=$mysqli->query($query)){
            return $resultado;
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function cargar_foto($mysqli,$no_control){
    try{
        if ($stmt = $mysqli->prepare("SELECT imagen FROM datos_egresado WHERE  no_control=? limit 1")) {
            $stmt->bind_param('i',$no_control); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            $resultado=$stmt->get_result();
            $stmt->close();
            $dato=$resultado->fetch_assoc();
            $img='fotos_egresados/'.$dato['imagen'].'';
            return $img;
        }else
        {
            $img='"Imagenes/businessman_green.png"';
            return $img;   
        }
    }catch(Exception $e){
        $img='"Imagenes/businessman_green.png"';
        return $img;
    }

}

function dt_egresado($no_control,$mysqli){
    try{    
        $query='select nombre,apellido_m,apellido_p,fecha_nacimiento,curp,
               telefono,email,calle,numero_casa,codigo_municipiofk,codigo_estadofk 
                FROM datos_egresado
               WHERE no_control='.$no_control.' limit 1';
        if($resultado=$mysqli->query($query)){
            return $resultado; 
        }else 
            return FALSE;
    }  catch (Exception $e){
        return FALSE;
    }

}

function estado_municipio($estado,$municipio,$mysqli){
    try{    
        $query='SELECT estado.nombre,municipio.nombre as municipio FROM estado,municipio WHERE (estado.codigo_estado="'.$estado.'" and municipio.codigo_municipio="'.$municipio.'")';
        if($resultado=$mysqli->query($query)){
        if($resultado->num_rows>0){
            $data=$resultado->fetch_assoc();
            return $data;
            
        }else{
            $estado=array('nombre'=>'vacio','municipio'=>'vacio');
            return $estado;}
            
        }
        else
            return FALSE;
    }  catch (Exception $e){
        return FALSE;
    }

}

function dt_academicos($no_control,$mysqli){
    try{    
        $query='SELECT historial_academico.no_registro, historial_academico.fecha_inicio, '
                . 'historial_academico.fecha_fin, especialidad.nombre as especialidad , '
                . 'carrera.nombre as carrera, historial_academico.titulado '
                . 'FROM historial_academico,especialidad,carrera '
                . 'WHERE (historial_academico.no_controlfk='.$no_control.' and '
                . 'historial_academico.codigo_carrerafk=carrera.codigo_carrera and '
                . 'historial_academico.codigo_especialidadfk=especialidad.codigo_especialidad) ';
        if($resultado=$mysqli->query($query)){
            return $resultado;
        }  else {

            return FALSE;}
    }catch(Exception $e){
        return FALSE;
    }

}

function dt_idioma($no_control,$mysqli){
    try{
        $query='SELECT idiomas_egresado.porcentaje_habla, idiomas_egresado.porcentaje_lec_escr, idioma.nombre as idioma FROM idiomas_egresado,idioma WHERE (no_controlfk='.$no_control.' and  idiomas_egresado.codigo_idiomafk=idioma.codigo_idioma)';
        if($resultado=$mysqli->query($query)){
            return $resultado;
        }  else {
            return FALSE;
        }
    }  
    catch (Exception $e){
        return FALSE;
    }
}

function dt_sw($no_control,$mysqli){
    try{
        $query='select nombre_sw from paquetes_sw where no_controlfk='.$no_control;
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}

function dt_posgrado($no_control,$mysqli){
    try{
        $query='select posgrado,nombre,escuela,titulado from posgrado where no_controlfk='.$no_control;
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}

function dt_social($no_control,$mysqli){
    try{
        $query='select nombre,tipo from actividad_social where no_controlfk='.$no_control;
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}