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

function  buscar($dato,$mysqli){
    if(is_numeric($dato)){
        $resultado=buscar_no_control($dato, $mysqli);
        return $resultado;
    }  else {
        $resultado=  buscar_nombre($dato, $mysqli);
        return $resultado;
    }
}

function buscar_no_control($dato,$mysqli){
  if($query=$mysqli->prepare("select nombre, apellido_p,apellido_m,no_control from datos_egresado where no_control like ?"))
        {
        $dato=$dato.'%';
        $query->bind_param('s',$dato);
        $query->execute();
        $resultado=$query->get_result();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE;  
}

function buscar_nombre($dato,$mysqli){
 $nombre=  explode(' ', $dato);
    if(count($nombre)==1){//secuencia un solo nombre
        $resultado=buscar_nombre_($nombre[0], $mysqli);
        return $resultado;
    }
    if(count($nombre)==2){
        $resultado=  buscar_nombre_incompleto($nombre[0], $nombre[1], $mysqli);//puede que busque en la siguiente secuencia nombre + primer apellido
        if($resultado==FALSE){
            $resultado=  buscar_nombre_($dato, $mysqli);//puede que busque en la secuencia primer nombre segundo nombre
            if($resultado==FALSE){
                $resultado=buscar_apellidos($nombre[0], $nombre[1], $mysqli);
                return $resultado;
            }                
        }
        else
            return $resultado;
    }
    if(count($nombre)>=3){
        $longitud=  count($nombre);
        $nombre_completo=$nombre[0];
        for($i=1;$i<(count($nombre)-2);$i++) {
            $nombre_completo=$nombre_completo.' '.$nombre[$i];
        }
        $resultado=  buscar_nombre_completo($nombre_completo, $nombre[count($nombre)-2], $nombre[count($nombre)-1], $mysqli);
        return $resultado;
    }
}

function buscar_nombre_($nombre,$mysqli){
    if($query=$mysqli->prepare("select nombre, apellido_p,apellido_m,no_control from datos_egresado where nombre like ?"))
        {
        $nombre=$nombre.'%';
        $query->bind_param('s',$nombre);
        $query->execute();
        $resultado=$query->get_result();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE; 
}
function buscar_nombre_incompleto($nombre,$apellido,$mysqli){
    if($query=$mysqli->prepare("select nombre, apellido_p,apellido_m,no_control from datos_egresado where( nombre like ? or apellido_p like ?)"))
        {
        $nombre=$nombre.'%';
        $apellido=$apellido.'%';
        $query->bind_param('ss',$nombre,$apellido);
        $query->execute();
        $resultado=$query->get_result();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE; 
}
function buscar_nombre_completo($nombre,$apellido_p,$apellido_m,$mysqli){
    if($query=$mysqli->prepare("select nombre, apellido_p,apellido_m,no_control from datos_egresado where( nombre like ? and apellido_p like ? and apellido_m like ?)"))
        {
        $nombre=$nombre.'%';
        $query->bind_param('sss',$nombre,$apellido_p,$apellido_m);
        $query->execute();
        $resultado=$query->get_result();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE; 
}

function buscar_apellidos($apellido_p,$apellido_m,$mysqli){
    if($query=$mysqli->prepare("select nombre, apellido_p,apellido_m,no_control from datos_egresado where( apellido_p like ? or apellido_m like ?)"))
        {
        $apellido_p=$apellido_p.'%';
        $apellido_m=$apellido_m.'%';
        $query->bind_param('ss',$apellido_p,$apellido_m);
        $query->execute();
        $resultado=$query->get_result();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE;
}
function buscar_todo($dato,$mysql){
   if($query=$mysqli->prepare("select nombre, apellido_p,apellido_m,no_control from datos_egresado where( nombre like ? or apellido_p like ? or apellido_m like ?)"))
        {
        $dato=$dato.'%';
        $query->bind_param('sss',$dato,$dato,$dato);
        $query->execute();
        $resultado=$query->get_result();
        if($resultado->num_rows>0)
            return $resultado;
        else 
            return FALSE;
        }
    else
        return FALSE; 
}