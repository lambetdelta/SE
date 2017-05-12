<?php
header("Content-Type: text/html;charset=utf-8"); 
include 'phpExcel/PHPExcel/IComparable.php';
include 'phpExcel/PHPExcel/Style/Supervisor.php';
include 'phpExcel/PHPExcel/Style.php';
include 'phpExcel/PHPExcel/Style/Fill.php';
include 'phpExcel/PHPExcel/Style/Border.php';
include 'phpExcel/PHPExcel/Style/Borders.php';

function validarFecha($cadena){
    try{    
        $fecha=  explode('-', $cadena);
        if(checkdate($fecha[1], $fecha[2], $fecha[0]))
            return TRUE;
        else
            return FALSE;
    }catch (Exception $e){
           return FALSE;
       }    
}  
function validarCarrera($carrera,$mysqli){
   try{
        $query='select nombre from carrera where codigo_carrera="'.$carrera.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows>0){
                return $resultado;
            }else
                return FALSE;
        
        }
    }catch (Exception $e){
            return FALSE;
        }  
}
function validarCarrera_num($carrera,$mysqli){
   try{
        $query='select codigo_carrera from carrera where codigo_carrera="'.$carrera.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows>0){
                return 1;
            }else
                return 0;
        }else
            return 3;
    }catch (Exception $e){
            return FALSE;
        }  
}
function anti_xss($form){//limpiar formularios recibidos 
        foreach ($form as &$valor):
            $valor=  strip_tags($valor);
        //sql
            $valor=str_replace("select","",$valor);
            $valor=str_replace("add","",$valor);
            $valor=str_replace("shutdown","",$valor);
            $valor=str_replace("insert","",$valor);
            $valor=str_replace("delete","",$valor);
            $valor=str_replace("update","",$valor);
            $valor=str_replace("drop","",$valor);
            $valor=str_replace("where","",$valor);
            $valor=str_replace("create","",$valor);
            $valor=str_replace("alter","",$valor);
            $valor=str_replace("index","",$valor);
            $valor=str_replace("show","",$valor);
            $valor=str_replace("execute","",$valor);
            $valor=str_replace("grant","",$valor);
            $valor=str_replace("super","",$valor);
            $valor=str_replace("lock","",$valor);
            $valor=str_replace("trigger","",$valor);
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
             //sql
            $valor=str_replace("select","",$valor);
            $valor=str_replace("add","",$valor);
            $valor=str_replace("shutdown","",$valor);
            $valor=str_replace("insert","",$valor);
            $valor=str_replace("delete","",$valor);
            $valor=str_replace("update","",$valor);
            $valor=str_replace("drop","",$valor);
            $valor=str_replace("where","",$valor);
            $valor=str_replace("create","",$valor);
            $valor=str_replace("alter","",$valor);
            $valor=str_replace("index","",$valor);
            $valor=str_replace("show","",$valor);
            $valor=str_replace("execute","",$valor);
            $valor=str_replace("grant","",$valor);
            $valor=str_replace("super","",$valor);
            $valor=str_replace("lock","",$valor);
            $valor=str_replace("trigger","",$valor);
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
function  buscar($dato,$mysqli,$cantidad,$no_registro){//busqueda general
    if(is_numeric($dato)){
        $resultado=buscar_no_control($dato, $mysqli,$cantidad,$no_registro);
        return $resultado;
    }  else {
        $resultado=  buscar_nombre($dato, $mysqli,$cantidad,$no_registro);
        return $resultado;
    }
}
function buscar_no_control($dato,$mysqli,$cantidad,$no_registro){
     $sentencia='select id_consecutivo,nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where (no_control like"'.$dato.'%" and  id_consecutivo> '.$no_registro.' ) limit '.$cantidad;
    if($query=$mysqli->query($sentencia))
        {
        if($query->num_rows>0){
            return $query;   
        }
        else
            return 'vacio';
        }
    else
        return FALSE;  
}

function buscar_nombre($dato,$mysqli,$cantidad,$no_registro){
 $nombre=  explode(' ', $dato);
    if(count($nombre)==1){//secuencia un solo nombre
        $resultado=buscar_nombre_($nombre[0], $mysqli,$cantidad,$no_registro);
        if($resultado==='vacio'){
            $resultado=  buscar_apellido_p($dato, $mysqli,$cantidad,$no_registro);
            return $resultado;
        }else
            return $resultado;
        return $resultado;
    }
    if(count($nombre)==2){//secuencia dos palabras nombre apellido nombre
        $resultado=  buscar_nombre_incompleto($nombre[0], $nombre[1], $mysqli,$cantidad,$no_registro);//puede que busque en la siguiente secuencia nombre + primer apellido
        if($resultado=='vacio'){
            $resultado=  buscar_nombre_($dato, $mysqli);//puede que busque en la secuencia primer nombre segundo nombre
            if($resultado=='vacio'){
                $resultado=buscar_apellidos($nombre[0], $nombre[1], $mysqli,$cantidad,$no_registro);//busqueda por apellidos
                return $resultado;
            }                
        }
        else
            return $resultado;
        return $resultado;
    }
    if(count($nombre)>=3){//cuando el dato es un nombre que puede tenerla secuencia nombre apellido apellido, nombre nombre apellido, nombre nombre nombre , o mas combianciones con n nombres
        $nombre_completo=$nombre[0];
        for($i=1;$i<(count($nombre)-2);$i++) {
            $nombre_completo=$nombre_completo.' '.$nombre[$i];
        }
        $resultado=  buscar_nombre_completo($nombre_completo, $nombre[count($nombre)-2], $nombre[count($nombre)-1], $mysqli,$cantidad,$no_registro);     
        $nombre_completo=$nombre[0];
        if($resultado==='vacio'){
            for($i=1;$i<(count($nombre)-1);$i++) {
            $nombre_completo=$nombre_completo.' '.$nombre[$i];
        }
            $resultado=  buscar_nombre_incompleto($nombre_completo, $nombre[count($nombre)-1], $mysqli,$cantidad,$no_registro);//busca por medio de dos nombres y el primer apellido
            if($resultado==='vacio'){
                $resultado=  buscar_nombre_($dato, $mysqli,$cantidad,$no_registro);//quizás tenga tres nombres o más, raro pero no imposible
                return $resultado;
            }  else {
                return $resultado;
            }
        }  else {
            return $resultado;
        }
        return $resultado;
    }
}

function buscar_nombre_($nombre,$mysqli,$cantidad,$no_registro){
     $sentencia='select id_consecutivo, nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( nombre like "'.$nombre.'%" and id_consecutivo>'.$no_registro.')limit '.$cantidad;
    if($query=$mysqli->query($sentencia))
        {
        if($query->num_rows>0)
            return $query;
        else 
            return 'vacio';
        }
    else
        return FALSE; 
}
function buscar_nombre_incompleto($nombre,$apellido,$mysqli,$cantidad,$no_registro){
     $sentencia='select id_consecutivo,nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( nombre like "'.$nombre.'%" or apellido_p like "'.$apellido.'%" and id_consecutivo>'.$no_registro.') LIMIT '.$cantidad;
    if($query=$mysqli->query($sentencia))
        {
      
        if($query->num_rows>0)
            return $query;
        else 
            return 'vacio';
        }
    else
        return FALSE; 
}
function buscar_nombre_completo($nombre,$apellido_p,$apellido_m,$mysqli,$cantidad,$no_registro){
     $sentencia='select id_consecutivo,nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( nombre like "'.$nombre.'" and apellido_p like "'.$apellido_p.'" and apellido_m like "'.$apellido_m.'%" and id_consecutivo>'.$no_registro.') LIMIT '.$cantidad;
    if($query=$mysqli->query($sentencia))
        {
        if($query->num_rows>0)
            return $query;
        else 
            return 'vacio';
        }
    else
        return FALSE; 
}
function buscar_apellidos($apellido_p,$apellido_m,$mysqli,$cantidad,$no_registro){
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where( apellido_p like "'.$apellido_p.'%" or apellido_m like "'.$apellido_m.'%" and id_consecutivo>'.$no_registro.') LIMIT '.$cantidad;
    if($query=$mysqli->query($sentencia))
        {
        if($query->num_rows>0)
            return $query;
        else 
            return 'vacio';
        }
    else
        return FALSE;
}
function buscar_apellido_p($apellido_p,$mysqli,$cantidad,$no_registro){
     $sentencia='select nombre, apellido_p,apellido_m,no_control,imagen from datos_egresado where (apellido_p like "'.$apellido_p.'%" and id_consecutivo>'.$no_registro.') LIMIT '.$cantidad;
   if($query=$mysqli->query($sentencia))
        {
        if($query->num_rows>0)
            return $query;
        else 
            return 'vacio';
        }
    else
        return FALSE;   
}
function buscar_todos($mysqli,$no_registro){
    try{
        $query='select no_control, id_consecutivo,nombre, apellido_p, '
                . 'apellido_m,imagen from datos_egresado '
                . 'where id_consecutivo>'.$no_registro.' limit 20';
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
        if ($stmt = $mysqli->query("SELECT imagen FROM datos_egresado WHERE  no_control=".$no_control." limit 1")) {
            $dato=$stmt->fetch_assoc();
            $img='fotos_egresados/'.$dato['imagen'].'';
            return $img;
        }else
        {
            $img='Imagenes/businessman_green.png';
            return $img;   
        }
    }catch(Exception $e){
        $img='Imagenes/businessman_green.pn"';
        return $img;
    }

}
function dt_egresado($no_control,$mysqli){
    try{    
        $query='select nombre,apellido_m,apellido_p,fecha_nacimiento,curp,genero,
               telefono,email,calle,numero_casa,cp,codigo_municipiofk,codigo_estadofk 
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
        $query='SELECT estado.nombre,municipio.nombre as municipio FROM estado,municipio WHERE (estado.codigo_estado="'.$estado.'" and municipio.codigo_municipio="'.$municipio.'") limit 1';
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
    }catch (Exception $e){
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
                . 'historial_academico.codigo_especialidadfk=especialidad.codigo_especialidad) limit 4';
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
        $query='SELECT idiomas_egresado.porcentaje_habla, idiomas_egresado.porcentaje_lec_escr, idioma.nombre as idioma FROM idiomas_egresado,idioma WHERE (no_controlfk='.$no_control.' and  idiomas_egresado.codigo_idiomafk=idioma.codigo_idioma) limit 5';
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
        $query='select nombre_sw from paquetes_sw where no_controlfk='.$no_control.' limit 7';
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
function dt_empresa($no_control,$mysqli){
    try{
        $query='select codigo_empresa,nombre,giro,email,puesto,web,año_ingreso from datos_empresa where no_controlfk='.$no_control.' limit 4';
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}
function dt_empresa_completa($codigo_empresa,$mysqli){
    try{
        $query='select datos_empresa.nombre,datos_empresa.giro,datos_empresa.email,'
                . 'datos_empresa.puesto,datos_empresa.web,datos_empresa.año_ingreso,'
                . 'datos_empresa.organismo,datos_empresa.razon_social,datos_empresa.telefono,'
                . 'datos_empresa.nombre_jefe,datos_empresa.calle,datos_empresa.no_domicilio,'
                . 'datos_empresa.medio_busqueda,datos_empresa.tiempo_busqueda,estado.nombre as estado,'
                . 'municipio.nombre as municipio from datos_empresa,estado,municipio'
                . ' where (datos_empresa.codigo_empresa='.$codigo_empresa.' and '
                . 'datos_empresa.codigo_estadofk=estado.codigo_estado '
                . 'and datos_empresa.codigo_municipiofk=municipio.codigo_municipio) limit 1';
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;   
    }catch(Exception $e){
        return FALSE;
    }
}
function dt_historial($no_control,$mysqli){
    try{
        $query='select nombre,email,web,telefono from historial_laboral where no_controlfk='.$no_control;
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function carreras($mysqli){
    try{
        $query='select nombre,codigo_carrera from carrera ';
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function administrador($mysqli){
    try{
        $query='select no_administrador,nombre from datos_administrador where nombre!="Administrador" ';
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function estadistica_fecha_carrera($fecha,$carrera,$mysqli){
    try{
        $query='select datos_egresado.nombre, '
                . 'datos_egresado.apellido_p,datos_egresado.apellido_m,datos_egresado.curp,'
                . 'datos_egresado.no_control,datos_egresado.genero,estado.nombre as estado,'
                . 'municipio.nombre as municipio,datos_egresado.cp,'
                . 'datos_egresado.ciudad_localidad,datos_egresado.colonia,'
                . 'datos_egresado.calle,datos_egresado.numero_casa,datos_egresado.email,'
                . 'datos_egresado.telefono,carrera.nombre ,'
                . 'historial_academico.fecha_inicio,historial_academico.fecha_fin,'
                . 'historial_academico.titulado from datos_egresado,carrera,'
                . 'historial_academico,estado,municipio where '
                . '(datos_egresado.codigo_estadofk=estado.codigo_estado and '
                . 'datos_egresado.codigo_municipiofk=municipio.codigo_municipio '
                . 'and historial_academico.no_controlfk=datos_egresado.no_control '
                . 'and historial_academico.codigo_carrerafk="'.$carrera.'" '
                . 'and YEAR(historial_academico.fecha_fin)="'.$fecha.'" '
                . 'and carrera.codigo_carrera=historial_academico.codigo_carrerafk) order by historial_academico.no_controlfk';
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function excel_query($query,$campos,$titulo,$creador,$descripcion,$clave_estudios){
    try{
        if(count($campos)==$query->field_count){
            $hojaExcel = new PHPExcel();
            //Informacion del excel
            $hojaExcel->
             getProperties()
                 ->setCreator($creador)
                 ->setTitle($titulo)
                 ->setSubject("Egresados")
                 ->setDescription($descripcion);

            $columna = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D',
                4 => 'E', 5 => 'F', 6 => 'G', 7 => 'H', 8 => 'I',
                9 => 'J', 10 => 'K', 11 => 'L', 12 => 'M', 13 => 'N',
                14 => 'O', 15 => 'P', 16 => 'Q', 17 => 'R', 18 => 'S',
                19 => 'T', 20 => 'U', 21 => 'V', 22 => 'W', 23 => 'X',
                24 => 'Y', 25 => 'Z');
            //imagen de titulo
            $imagen= imagen_excel();
            if($imagen==FALSE){
                //clave de programa de estudios
                $hojaExcel->getActiveSheet()->setCellValue('A1', 'Clave de estudios:'.$clave_estudios.'ERROR: Imposible cargar banner');
            }else{
                $hojaExcel->getActiveSheet()->mergeCells('A1:'.$columna[count($campos)].'1');
                $hojaExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(113);
                $imagen->setWorksheet($hojaExcel->getActiveSheet());
               //clave de programa de estudios
                $hojaExcel->getActiveSheet()->setCellValue('A1', 'Clave de estudios:'.$clave_estudios);
            }
            //nombre de los campos
            $x=0;
            while ($x <count($campos)){//ingresar nombres de campos
                $hojaExcel->setActiveSheetIndex(0)
                ->setCellValue($columna[$x].'2', $campos[$x]);
                ++$x;

            }
            $hojaExcel->getActiveSheet()->getStyle('A2:'.$columna[$x].'2')//colorear encabezados
            ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setARGB('b1ffa4');
            //total de egresados
            $hojaExcel->setActiveSheetIndex(0)
                ->setCellValue($columna[$x].'2', 'Total de egresados');
            $x++;
            $hojaExcel->setActiveSheetIndex(0)
                ->setCellValue($columna[$x].'2', $query->num_rows);
            $hojaExcel->getActiveSheet()->getStyle('T2:U2')//colorear encabezados
            ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setARGB('fd1209');
            $hojaExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
            $hojaExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
            //datos de consulta
            $f=3;
            while ($fila=$query->fetch_array(MYSQLI_NUM)){//extraer fila
                $c=0;
                while($c<  count($fila)){//extraer campo
                    $hojaExcel->setActiveSheetIndex(0)
                    ->setCellValue($columna[$c].$f, $fila[$c]);
                    ++$c;
                }
             ++$f;
            }
            //estilos finales
            --$c;//regresar a la ultima columna usada y fila
            --$f;
            $borders = array(//bordes 
                'borders' => array(
                  'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                    )
                  ),
                );   
            $hojaExcel->getActiveSheet()->getStyle('A1:'.$columna[$c].$f)//bordes del todo el documento
                    ->applyFromArray($borders);
            $hojaExcel->getActiveSheet()->getStyle('A3:'.$columna[$c].$f)//relleno del resto de las celdas
                            ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('bab4ef');
            $x=0;
            while($x<=$c){//ancho automatico de columnas
                $hojaExcel->getActiveSheet()->getColumnDimension($columna[$x])->setAutoSize(true);
                ++$x;
            }
            return $hojaExcel;
        }else
            return false;

    }  catch (Exception $e){
        return FALSE;
    }

}
function imagen_excel(){  
    try{
       $imagen = new PHPExcel_Worksheet_Drawing(); 
       $imagen->setName('banner'); 
       $imagen->setDescription('Image inserted by Zeal'); 
       $imagen->setPath('../Imagenes/banner.png'); 
       $imagen->setHeight(150); 
       $imagen->setCoordinates('D1'); 
       $imagen->setOffsetX(0); 
       $imagen->setRotation(0); 
       $imagen->getShadow()->setVisible(true); 
       $imagen->getShadow()->setDirection(36); 
       return $imagen;
    }  catch (Exception $e){
        return FALSE;
    }
}
function validar_egresado($form){
    $x=1;
    $long=count($form);
    while($x<$long){
        if(is_numeric($form['no_control'.$x])){
            
        }else
            return FALSE;
    }
    return TRUE;
}
function nuevo_egresado($no_control,$mysqli){
    try{
        if(buscar_egresado($no_control, $mysqli))
            return '3';
        else{
            $salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $pass=hash('sha512',$no_control);
            $password=hash('sha512',$pass.$salt);
            $query='insert into datos_egresado(no_control,salt,password) values('.$no_control.',"'.$salt.'","'.$password.'")';
            if($mysqli->query($query)){
                if($mysqli->affected_rows>0)
                    return '1';
                else
                    return FALSE;
            }else
                return FALSE;
        }
    }catch(Exception $e){
        return FALSE;
    } 
}
function buscar_egresado($no_control,$mysqli){
    try{
        $query='select no_control from datos_egresado where no_control='.$no_control.' limit 1';
        if($res=$mysqli->query($query)){
            if($res->num_rows>0)
                return TRUE;
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function borrar_egresado($mysqli,$no_control){
    $query='delete from datos_egresado where no_control='.$no_control;
    if($mysqli->query($query)){
        if($mysqli->affected_rows>0)
            return 1;
        else
            return 0;
    }else
        return 3;
}
function nuevo_adm($mysqli,$nombre,$pass){//borrar social
    try{
        $salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password=hash('sha512',$pass.$salt);
        if ($stmt = $mysqli->prepare("Insert into datos_administrador(nombre, pass,salt) values(?,?,?) ")) {
            $stmt->bind_param('sss',$nombre,$password,$salt); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0){
                    $stmt->close();
                    return 1;}
                else{
                    $stmt->close();
                    return 2;}
            }else
                return 3;
        }else
            return FALSE;
    }catch(Exception $E){
        return FALSE;
    }

}
function borrar_adm($mysqli,$no_adm){
    try{
        if($query=$mysqli->prepare('delete from datos_administrador where no_administrador=?')){
            $query->bind_param('i',$no_adm);
            if($query->execute()){
                if($query->affected_rows>0)
                    return 1;
                else
                    return 2;
            }else
                return 3;
    }else
        return 3;
    }catch(Exception $e){
        return FALSE;
    }
}
function validar_adm($mysqli,$adm){
    $query='select no_administrador from datos_administrador where no_administrador='.$adm;
    if($res=$mysqli->query($query)){
        if($res->num_rows>0)
            return 1;
        else
            return 0;
    }else
        return 3;
}
function validar_nombre_adm($mysqli,$adm){
   $query='select no_administrador from datos_administrador where nombre="'.$adm.'"';
    if($res=$mysqli->query($query)){
        if($res->num_rows==0)
            return 1;
        else
            return 0;
    }else
        return 3; 
}
function editar_adm($mysqli,$nombre,$pass,$no_adm){
    try{
        $salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password=hash('sha512',$pass.$salt);
        if($query=$mysqli->prepare('update  datos_administrador set nombre=?, pass=?, salt=? where no_administrador=?')){
            $query->bind_param('sssi',$nombre,$password,$salt,$no_adm);
            if($query->execute()){
                if($query->affected_rows>0)
                    return 1;
                else
                    return 2;
            }else
                return 3;
    }else
        return 3;
    }catch(Exception $e){
        return FALSE;
    }
}
function validar_escuela($director,$tel,$web,$email,$domicilio,$cargo,$fecha_con){
        $respuesta=array();
        $respuesta['resultado']=FALSE;
        $respuesta['mensaje']='Error de validación';
        if(strlen($director)<=60){
            $respuesta['resultado']=TRUE;
            $respuesta['mensaje']='bien';
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Nombre inválido';
            return $respuesta;  
        }
        if(strlen($domicilio)<=80){
            $respuesta['resultado']=TRUE;
            $respuesta['mensaje']='bien';
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Nombre inválido';
            return $respuesta;  
        }
        if(strlen($cargo)<=40){
            $respuesta['resultado']=TRUE;
            $respuesta['mensaje']='bien';
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Nombre inválido';
            return $respuesta;  
        }
        if(strlen($fecha_con)<=60){
            $respuesta['resultado']=TRUE;
            $respuesta['mensaje']='bien';
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Nombre inválido';
            return $respuesta;  
        }
        if(validarEmail($email)){
          
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo email  inválido';
            return $respuesta;  
        }
        if(validarWeb($web)){
          
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo web  inválido';
            return $respuesta;  
        }
        if(validarTelefono($tel)){
          
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo teléfono  inválido';
            return $respuesta;  
        }
        
        return $respuesta;
}
function validarEmail($cadena){//cortesia de Juan Valencia Escalante  en http://www.jveweb.net/archivo/2011/07/algunas-expresiones-regulares-y-como-usarlas-en-php.html
    try{
        $cadena=  trim($cadena);
        if(strlen( $cadena)<=40){
            $pattern = "/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/";
            if (preg_match($pattern, $cadena)) {
                return TRUE;
            }
            return FALSE;
        
        }else
            return FALSE;
    }catch (Exception $e){
        return FALSE;
    } 
}  
function validarWeb($web){
    {
    if (strlen($web)<=40)
        return (preg_match('/^[http:\/\/|www.|https:\/\/]/i', $web));
    }
}
function validarEstado($mysqli,$estado){
     try{
        $query='select codigo_estado from estado where codigo_estado="'.$estado.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows>0){
                return 1;
            }else
                return 0;
        
        }else
            return 3;
    }catch (Exception $e){
            return FALSE;
    } 
}
function validarMun($municipio,$mysqli){
    try{
        $query='select codigo_municipio from municipio where codigo_municipio="'.$municipio.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows>0){
                return 1;
            }else
                return 0;
        }else
            return 3;;
    }catch (Exception $e){
            return FALSE;
        } 
}
function validarTelefono($cadena){//cortesia de Juan Valencia Escalante  en http://www.jveweb.net/archivo/2011/07/algunas-expresiones-regulares-y-como-usarlas-en-php.html
    try{
        $cadena=  trim($cadena);
        if(strlen( $cadena)<=26){
            $pattern = "/^0{0,2}([\+]?[\d]{1,3} ?)?([\(]([\d]{2,3})[)] ?)?[0-9][0-9 \-]{6,}( ?([xX]|([eE]xt[\.]?)) ?([\d]{1,5}))?$/D";
            if (preg_match($pattern, $cadena)) {
                return TRUE;
            }
            return FALSE;
        
        }else
            return FALSE;
        }
    catch (Exception $e){
        return FALSE;
    } 
}    
function guardar_dt_escuela($director,$tel,$web,$email,$domicilio,$cargo,$fecha_con){
    try{
        $validar='../contenidos/datos.txt';
        if(file_exists($validar)){
            $fp = fopen("../contenidos/datos.txt", "w");
            fwrite($fp,$fecha_con.PHP_EOL);
            fwrite($fp,$director.PHP_EOL);
            fwrite($fp,$cargo.PHP_EOL);
            fwrite($fp,$domicilio.PHP_EOL);
            fwrite($fp,$tel.PHP_EOL);
            fwrite($fp,$email.PHP_EOL);
            fwrite($fp,$web.PHP_EOL);
            return TRUE;
             }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function datos(){//datos basicos del servidor 
    try{
	$fp = fopen("../contenidos/datos.txt", "r");
	$fechaCon = fgets($fp);
	$direccion = fgets($fp);
	$cargo = fgets($fp);
	$domicilio= fgets($fp);
        $tel = fgets($fp);
	$email = fgets($fp);
	$web = fgets($fp);
	fclose($fp);
	return array($fechaCon,$direccion,$cargo,$domicilio,$tel,$email,$web);
    }catch(Exception $e){
        return array('$fechaCon','$direccion','$cargo','$domicilio','$tel','$email','$web');
    }
}
function validar_img($img){
    $respuesta=array();
    $respuesta['resultado']=FALSE;
    $respuesta['mensaje']='Error';
    $nombre = $img["name"];
    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
    $ruta_provisional = $img["tmp_name"];
    $size = $img["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    if(is_uploaded_file($ruta_provisional)){
        if($extension=='png'){
            if($size<=1024*1024){
                if($width<=1400 && $height<=200){
                    if($width>=1000 && $height>=100){
                        $respuesta['resultado']=TRUE;
                        $respuesta['mensaje']='bien';
                    }else
                        $respuesta['mensaje']='El ancho de la imagen  debe tener un minimo de 1000 px y la altura minima de 100px';
                }else{
                   $respuesta['mensaje']='El ancho de la imagen debe tener un máximo de 1400 px y la altura solo 200px'; 
                }
            }else
                $respuesta['mensaje']='Máximo 1 mb de espacio en memoria';
        }else
            $respuesta['mensaje']='Solo se permiten imagenes png';
    }else
        $respuesta['mensaje']='Posible ataque';
    
    return $respuesta;
        
}
function validar_firma($img){
    $respuesta=array();
    $respuesta['resultado']=FALSE;
    $respuesta['mensaje']='Error';
    $nombre = $img["name"];
    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
    $ruta_provisional = $img["tmp_name"];
    $size = $img["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    if(is_uploaded_file($ruta_provisional)){
        if($extension=='png'){
            if($size<=1024*1024){
                if($width<=260 && $height<=100){
                    if($width>=200 && $height>=80){
                        $respuesta['resultado']=TRUE;
                    $respuesta['mensaje']='bien';
                    }else
                        $respuesta['mensaje']='El ancho de la imagen tiene un minimo de 200 px y la altura minima 800px   '; 
                }else{
                   $respuesta['mensaje']='El ancho de la imagen tiene un máximo de 1400 px y la altura solo 200px'; 
                }
            }else
                $respuesta['mensaje']='Solo máximo 1 mb  ';
        }else
            $respuesta['mensaje']='Solo se permiten imagenes png';
    }else
        $respuesta['mensaje']='Posible ataque';
    return $respuesta;   
}
function nuevo_estado($mysqli,$nombre){
    $cons='select codigo_estado from estado';
    if($res=$mysqli->query($cons)){
        $id=$res->num_rows;
        if($query=$mysqli->prepare('insert into estado(codigo_estado,nombre) values(?,?)')){
        $query->bind_param('ss',$id,$nombre);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 2;
        }else
          return 3;  
    }  
    else 
        return 3;
    }else
        return 3;
}
function borrar_estado($mysqli,$codigo){
    if($query=$mysqli->prepare('delete from estado where codigo_estado=?')){
        $query->bind_param('s',$codigo);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 2;
        }else
          return 3;  
    }  
    else 
        return 3;
}
function nuevo_municipio($mysqli,$nombre,$estado){
    $cons='select codigo_municipio from municipio';
    if($res=$mysqli->query($cons)){
        $id=$res->num_rows;
        if($query=$mysqli->prepare('insert into municipio(codigo_municipio,nombre,codigo_estadofk) values(?,?,?)')){
            $query->bind_param('sss',$id,$nombre,$estado);
            if($query->execute()){
               if($query->affected_rows>0)
                   return 1;
               else
                   return 2;
            }else
              return 3;  
        }  
        else 
            return 3;
    }else {
        return 3;
    }
}
function borrar_municipio($mysqli,$codigo){
    if($query=$mysqli->prepare('delete from municipio where codigo_municipio=?')){
        $query->bind_param('s',$codigo);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 2;
        }else
          return 3;  
    }  
    else 
        return 3;
}
function validarIdioma($idioma,$mysqli){
   try{
        $query='select codigo_idioma from idioma where codigo_idioma="'.$idioma.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows >0){
                return 1;
            }else
                return 0;
        
        }else
            return FALSE;
    }catch (Exception $e){
            return FALSE;
        }  
}
function nuevo_idioma($mysqli,$codigo,$nombre){
    if($query=$mysqli->prepare('insert into idioma(codigo_idioma,nombre) values(?,?)')){
        $query->bind_param('ss',$codigo,$nombre);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 2;
        }else
          return 3;  
    }  
    else 
        return 3;
}
function borrar_idioma($mysqli,$codigo){
    if($query=$mysqli->prepare('delete from idioma where codigo_idioma=?')){
        $query->bind_param('s',$codigo);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 2;
        }else
          return 3;  
    }  
    else 
        return 3;
}
function nueva_carrera($mysqli,$codigo,$nombre){
    if($query=$mysqli->prepare('insert into carrera(codigo_carrera,nombre) values(?,?)')){
        $query->bind_param('ss',$codigo,$nombre);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 0;
        }else
          return 3;  
    }  
    else 
        return 3;
}

function borrar_carrera($mysqli,$codigo){
    if($query=$mysqli->prepare('delete from carrera where codigo_carrera=?')){
        $query->bind_param('s',$codigo);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 0;
        }else
          return 3;  
    }  
    else 
        return 3;
}
function validarEspecialidad($especialidad,$mysqli){
   try{
        $query='select codigo_especialidad from especialidad where codigo_especialidad="'.$especialidad.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows>0){
                return 1;
            }else
                return 0;
        
        }else
            return 3;
    }catch (Exception $e){
            return FALSE;
        }  
}
function nueva_especialidad($mysqli,$codigo,$nombre,$carrera){
    if($query=$mysqli->prepare('insert into especialidad(codigo_especialidad,nombre,codigo_carrerafk) values(?,?,?)')){
        $query->bind_param('sss',$codigo,$nombre,$carrera);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 0;
        }else
          return 3;  
    }  
    else 
        return 3;
}
function borrar_especialidad($mysqli,$codigo){
    if($query=$mysqli->prepare('delete from especialidad where codigo_especialidad=?')){
        $query->bind_param('s',$codigo);
        if($query->execute()){
           if($query->affected_rows>0)
               return 1;
           else
               return 0;
        }else
          return 3;  
    }  
    else 
        return 3;
}