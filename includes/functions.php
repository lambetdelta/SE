<?php
include_once 'psl-config.php';
header("Content-Type: text/html;charset=utf-8"); 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Configura un nombre de sesión personalizado.
    $secure = SECURE;
    // Esto detiene que JavaScript sea capaz de acceder a la identificación de la sesión.
    $httponly = true;
    // Obliga a las sesiones a solo utilizar cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Obtiene los params de los cookies actuales.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Configura el nombre de sesión al configurado arriba.
    session_name($session_name);
    session_start();            // Inicia la sesión PHP.
    session_regenerate_id();    // Regenera la sesión, borra la previa. 
}

function login($N_control, $password, $mysqli) {
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
    try{
    if ($stmt = $mysqli->prepare("SELECT no_control, password,nombre,salt 
        FROM datos_egresado
       WHERE no_control = ?
        LIMIT 1")) {
        $stmt->bind_param('i', $N_control);  // Une “$no:control” al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();
        // Obtiene las variables del resultado.
        $stmt->bind_result($No_control, $pass, $nombre,$salt);
        $stmt->fetch();
        // Hace el hash de la contraseña con una sal única.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // Si el usuario existe, revisa si la cuenta está bloqueada
            // por muchos intentos de conexión.
 
            if (checkbrute($No_control, $mysqli) == true) {	
                return 3;
            } else {
                // Revisa que la contraseña en la base de datos coincida 
                // con la contraseña que el usuario envió.
                if ($pass == $password) {
                    // ¡La contraseña es correcta!
                    // Obtén el agente de usuario del usuario.
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    //  Protección XSS ya que podríamos imprimir este valor.
                    $No_control = preg_replace("/[^0-9]+/", "", $No_control);
                    $_SESSION['No_control'] = $No_control;
                    // Protección XSS ya que podríamos imprimir este valor.
                    $Nombre = preg_replace("/[^a-zA-Z0-9_\-]+/","", $Nombre);
                    $_SESSION['Nombre'] = $nombre;
                    $_SESSION['login_string'] = hash('sha512',$pass.$user_browser);
                    // Inicio de sesión exitoso
					
                    return 1;
                } else {
                    // La contraseña no es correcta.
                    // Se graba este intento en la base de datos.
                    $now = time();
                    $mysqli->query('INSERT INTO intentos(no_controlfk, time)
                                    VALUES ('.$N_control.',"'.$now.'")');
                    return false;
                }
            }
        } else {
            // El usuario no existe.
            return 'NO_EXIST';
        }
    } else {
        return FALSE;
    }
    
    }  catch (Exception $e){
        return $e; 
    }
}

function checkbrute($no_control, $mysqli) {
    // Obtiene el timestamp del tiempo actual.
    $now = time();
 
    // Todos los intentos de inicio de sesión se cuentan desde las 2 horas anteriores.
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM intentos 
                             WHERE no_controlfk= ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $no_control);
 
        // Ejecuta la consulta preparada.
        $stmt->execute();
        $stmt->store_result();
 
        // Si ha habido más de 5 intentos de inicio de sesión fallidos.
        if ($stmt->num_rows > 10) {
            return TRUE;
        } else {
            return false;
        }
    }
}
function checkbrute_adm($adm, $mysqli) {
    // Obtiene el timestamp del tiempo actual.
    $now = time();
 
    // Todos los intentos de inicio de sesión se cuentan desde las 2 horas anteriores.
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM intentos_adm 
                             WHERE adm= ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('s', $adm);
 
        // Ejecuta la consulta preparada.
        $stmt->execute();
        $stmt->store_result();
 
        // Si ha habido más de 5 intentos de inicio de sesión fallidos.
        if ($stmt->num_rows > 10) {
            return TRUE;
        } else {
            return false;
        }
    }
}


function login_check($mysqli) {
    // Revisa si todas las variables de sesión están configuradas.
    try{
    if (isset($_SESSION['No_control'], 
                        $_SESSION['Nombre'], 
                        $_SESSION['login_string'])) {
 
        $No_control = $_SESSION['No_control'];
        $login_string = $_SESSION['login_string'];
        $Nombre = $_SESSION['Nombre'];
 		
        // Obtiene la cadena de agente de usuario del usuario.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM datos_egresado 
                                      WHERE no_control = ? LIMIT 1")) {
            // Une “$egresado_id” al parámetro.
            $stmt->bind_param('i', $No_control);
            $stmt->execute();   // Ejecuta la consulta preparada.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Si el usuario existe, obtiene las variables del resultado.
                $stmt->bind_result($pass);
                $stmt->fetch();
                $login_check = hash('sha512',$pass.$user_browser);

                if ($login_check == $login_string) {
                    // ¡¡Conectado!! 
                    return true;
                } else {
                    // No conectado.
                    return false;
                }
            } else {
                // No conectado.
                return false;
            }
        } else {
            // No conectado.
            return false;
        }
    } else {
        // No conectado.
        return false;
    }
    
    }  catch (Exception $e){
        return FALSE;
    }
}

function login_adm($Usuario, $Password, $mysqli) {
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
    try{
    if ($stmt = $mysqli->prepare("SELECT nombre, pass,salt 
        FROM datos_administrador
       WHERE nombre = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $Usuario);  // Une “$no:control” al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();
        // Obtiene las variables del resultado.
        $stmt->bind_result($administrador,$pass,$salt);
        $stmt->fetch();
        // Hace el hash de la contraseña con una sal única.
        $password = hash('sha512',$Password.$salt);
        if ($stmt->num_rows == 1) {
            // Si el usuario existe, revisa si la cuenta está bloqueada
            // por muchos intentos de conexión.
 
            if (checkbrute_adm($Usuario, $mysqli) == true) {
                // La cuenta está bloqueada.
                // Envía un correo electrónico al usuario que le informa que su cuenta está bloqueada.
				
                return 3;
            } else {
                // Revisa que la contraseña en la base de datos coincida 
                // con la contraseña que el usuario envió.
                if ($pass == $password) {
                    // ¡La contraseña es correcta!
                    // Obtén el agente de usuario del usuario.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];    
                    $_SESSION['Usuario'] = $administrador;
                    $_SESSION['login_string_adm'] = hash('sha512',$pass.$user_browser);
                    // Inicio de sesión exitoso
					
                    return 1;
                } else {
                    // La contraseña no es correcta.
                    // Se graba este intento en la base de datos.
                    $now = time();
                    $mysqli->query('INSERT INTO intentos_adm(adm, time)
                                    VALUES ("'.$Usuario.'","'.$now.'")');
                    return false;
                }
            }
        } else {
            // El usuario no existe.
            return false;
        }
    }
    
}catch(Exception $e){
    return $e;
}
}
function login_check_adm($mysqli) {
try{    
// Revisa si todas las variables de sesión están configuradas.
    if (isset($_SESSION['Usuario'],$_SESSION['login_string_adm'])) {
 
        $Usuario = $_SESSION['Usuario'];
        $login_string = $_SESSION['login_string_adm'];		
        // Obtiene la cadena de agente de usuario del usuario.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt=$mysqli->prepare("SELECT pass FROM datos_administrador  WHERE nombre = ? LIMIT 1")){
            
            $stmt->bind_param('s', $Usuario);
            $stmt->execute();   // Ejecuta la consulta preparada.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Si el usuario existe, obtiene las variables del resultado.
                $stmt->bind_result($pass);
                $stmt->fetch();
                $login_check = hash('sha512',$pass.$user_browser);
                if ($login_check == $login_string) {
                    // ¡¡Conectado!! 
                    return TRUE;
                } else {
                    // No conectado.
                    return FALSE;
                }
            } else {
                // No conectado.
                return FALSE;
            }
        } else {
            // No conectado.
            return FALSE;
        }
    } else {
        // No conectado.
        return FALSE;
    }
}  catch (Exception $e){
    return FALSE;
}
}

//Sanea la URL de PHP_SELF
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // Solo nos interesan los enlaces relativos de  $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function fecha(){//calcular la fecha en base sistema y mexico
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$mes=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$fecha="Fecha:".$dias[date('w')]." ".date('j')." de ".$mes[date('n')-1]." del ".date('Y');
	return $fecha;
	}

function datos(){//datos basicos del servidor 
    try{
	$fp = fopen("contenidos/datos.txt", "r");
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
			
function primer_login($N_control,$mysqli) {//identificar primer ingreso de ususarios
    // Usar declaraciones preparadas significa que la inyección de SQL no será posible.
    try{
        if ($stmt = $mysqli->prepare("SELECT  nombre 
            FROM datos_egresado
           WHERE no_control = ?
            LIMIT 1")) {
            $stmt->bind_param('i', $N_control);  // Une “$no:control” al parámetro.
            $stmt->execute();    // Ejecuta la consulta preparada.
            $stmt->store_result();
            // Obtiene las variables del resultado.
            $stmt->bind_result($nombre);
            $stmt->fetch();
                    if($nombre=="vacio"){
                            return true;}
                    else{
                            return false;}
        }    
    }catch (Exception $e){
                    return FALSE;
                }
}
		
function dt_egresado($no_control,$mysqli){
    try{    
        $query='select nombre,apellido_m,apellido_p,fecha_nacimiento,curp,genero,
               telefono,email,ciudad_localidad,colonia,calle,numero_casa,cp,codigo_municipiofk,codigo_estadofk 
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
    }  catch (Exception $e){
        return FALSE;
    }

}

function actualizar_egresado($mysqli,$nombre,$apellido_p,$apellido_m,$curp,$genero,$fecha_nac,$tel,$email,$ciudad,$colonia,$calle,$no_casa,$cp,$estado,$municipio,$no_control){
    try{    
        if ($stmt = $mysqli->prepare("UPDATE datos_egresado SET nombre=?,apellido_m=?,apellido_p=?,fecha_nacimiento=?,curp=?,genero=?,telefono=?,email=?,ciudad_localidad=?,colonia=?,calle=?,numero_casa=?,cp=?,codigo_municipiofk=?,codigo_estadofk=? where no_control=?")) {
            $stmt->bind_param('ssssssssssssissi', $nombre,$apellido_p,$apellido_m,$fecha_nac,$curp,$genero,$tel,$email,$ciudad,$colonia,$calle,$no_casa,$cp,$municipio,$estado,$no_control); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                return TRUE;
            }else
                return FALSE;
        }else
            return FALSE;

    }catch(Exception $e){
        return FALSE;
    }
}

function dt_academicos($no_control,$mysqli){
    try{    
        $query='SELECT historial_academico.no_registro, historial_academico.fecha_inicio, '
                . 'historial_academico.fecha_fin, especialidad.nombre as especialidad , '
                . 'carrera.nombre as carrera, historial_academico.titulado,carrera.codigo_carrera,especialidad.codigo_especialidad '
                . 'FROM historial_academico,especialidad,carrera '
                . 'WHERE (historial_academico.no_controlfk='.$no_control.' and '
                . 'historial_academico.codigo_carrerafk=carrera.codigo_carrera  and '
                . 'historial_academico.codigo_especialidadfk=especialidad.codigo_especialidad) limit 4';
        if($resultado=$mysqli->query($query)){
            return $resultado;
        }  else {

            return FALSE;}
    }catch(Exception $e){
        return FALSE;
    }

}
	
function guardar_dt_academicos($mysqli,$no_control,$fecha_inicio,$fecha_fin,$codigo_carrera,$codigo_especialidad,$titulado){//nueva carrera
    try{    
        if($stmt = $mysqli->prepare("INSERT INTO historial_academico (no_controlfk,fecha_inicio,fecha_fin,codigo_carrerafk,codigo_especialidadfk,titulado) VALUES (?,?,?,?,?,?)")) {
            $stmt->bind_param('isssss', $no_control,$fecha_inicio,$fecha_fin,$codigo_carrera,$codigo_especialidad,$titulado); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0){
                    $stmt->close();
                    return TRUE;}
                else{
                    $stmt->close();
                    return FALSE;}
            }else
                return FALSE;
         }else
             return FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}

function contar_carrera($mysqli,$No_control){//verificar el max de carreras permitidas
    try{   
        $query="SELECT no_registro FROM historial_academico WHERE no_controlfk=$No_control"; 
        if ($stmt = $mysqli->query($query)) {  // Ejecuta la consulta preparada.
            if ($stmt->num_rows>=4)
                return TRUE;
            else
                return FALSE;    
        }else
            return FALSE;

    }catch(Exception $e){
        return FALSE;
    }
    
    }
function actualizar_dt_academicos($mysqli,$no_control,$fecha_inicio,$fecha_fin,$codigo_carrera,$codigo_especialidad,$registro,$titulado){//actualizar carrera
    try{    
        if ($stmt = $mysqli->prepare("UPDATE historial_academico SET fecha_inicio=?,fecha_fin=?,codigo_carrerafk=?,codigo_especialidadfk=?,titulado=? where (no_controlfk=? AND no_registro=?)" )) {
            $stmt->bind_param('sssssii',$fecha_inicio,$fecha_fin,$codigo_carrera,$codigo_especialidad,$titulado,$no_control,$registro); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0){
                    $stmt->close();
                    return 1;}
                else{
                    $stmt->close();
                    return 0;}
            }else
                return 3;
        }else
            return 3;
    }catch(Exception $e){
            return FALSE;}        
}
function borrar_dt_academicos($mysqli,$no_control,$registro){//actualizar carrera
    try{    
        if ($stmt = $mysqli->prepare("DELETE FROM historial_academico WHERE (no_controlfk=? AND no_registro=?)" )) {
            $stmt->bind_param('ii',$no_control,$registro); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0){
                    $stmt->close();
                    return TRUE;}
                else{
                    $stmt->close();
                    return FALSE;}
            }else
                return FALSE;
        }else
            return FALSE;
    }catch(Exception $e){
            return FALSE;}        
}
function dt_idioma($no_control,$mysqli){
    try{
        $query='SELECT idiomas_egresado.porcentaje_habla,idiomas_egresado.id_consecutivo, idiomas_egresado.porcentaje_lec_escr, idioma.nombre as idioma FROM idiomas_egresado,idioma WHERE (no_controlfk='.$no_control.' and  idiomas_egresado.codigo_idiomafk=idioma.codigo_idioma) limit 8';
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

function editar_idioma($mysqli,$no_control,$idioma,$habla,$lectura,$registro){//actualizar idioma no usado pero disponible 
    try{    
        if ($stmt = $mysqli->prepare("UPDATE idiomas_egresado SET codigo_idiomafk=?,porcentaje_habla=?,porcentaje_lec_escr=?, WHERE (no_controlfk=? AND id_consecutivo=?)" )) {
            $stmt->bind_param('sssii',$idioma,$habla,$lectura,$no_control,$registro); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return TRUE;}
            else{
                $stmt->close();
                return FALSE;}
        }
    }catch(Exception $e){
            return FALSE;}       
}	

function borrar_idioma($mysqli,$no_control,$registro){//borrar idioma
    try{
        if ($stmt = $mysqli->prepare("DELETE FROM idiomas_egresado WHERE (no_controlfk=? AND id_consecutivo=?)" )) {
            $stmt->bind_param('ii',$no_control,$registro); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0){
                    $stmt->close();
                    return TRUE;}
                else{
                    $stmt->close();
                    return FALSE;}
            }else
                return FALSE;
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function contar_idioma($mysqli,$No_control){//verificar el max de idiomas permitidas
    try{    
        $query="SELECT codigo_idiomafk FROM idiomas_egresado  WHERE no_controlfk=$No_control";
        if ($stmt = $mysqli->query($query)) {   // Ejecuta la consulta preparada.
            if ($stmt->num_rows >9)
                    return 1;
                else
                    return 0;
        }else
            return FALSE;

    }catch(Exception $e){
            return FALSE;}
        
}
	
function guardar_idioma($mysqli,$no_control,$pocentaje_habla,$porcentaje_lec_escr,$codigo_idiomafk){//nueva idioma
    try{    
        if ($stmt = $mysqli->prepare("INSERT INTO idiomas_egresado(no_controlfk,porcentaje_habla,porcentaje_lec_escr,codigo_idiomafk) VALUES (?,?,?,?)")) {
            $stmt->bind_param('iiis', $no_control,$pocentaje_habla,$porcentaje_lec_escr,$codigo_idiomafk); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0){
                    $stmt->close();
                    return true;}
                else{
                    $stmt->close();
                return false;}        
                }else
                    return FALSE;
        }else
            return FALSE;
    }catch(Exception $e){
            return FALSE;}
        
}	

function dt_sw($no_control,$mysqli){
    try{
        $query='select nombre_sw,id_consecutivo from paquetes_sw where no_controlfk='.$no_control.' limit 7';
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}

function guardar_sw($mysqli,$no_control,$sw){//nueva sw
    try{
        if ($stmt = $mysqli->prepare("INSERT INTO paquetes_sw(no_controlfk,nombre_sw) VALUES (?,?)")) {
            $stmt->bind_param('is', $no_control,$sw); 
            if($stmt->execute()){    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0)
                    return TRUE;
                else
                    return FALSE;        
            }else
                return FALSE;
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function contar_sw($mysqli,$No_control){//verificar el max de sw permitidas
    try{    
        $query="SELECT id_consecutivo FROM paquetes_sw  WHERE no_controlfk=$No_control";
        if ($stmt = $mysqli->query($query)) {   // Ejecuta la consulta preparada.
            if ($stmt->num_rows>=7)
                return TRUE;
            else
                return FALSE;
        }else
            return FALSE;		
    }catch(Exception $e){
        return FALSE;    
    }

}
function borrar_sw($mysqli,$no_control,$registro){//borrar sw
    try{
        if ($stmt = $mysqli->prepare("DELETE FROM paquetes_sw WHERE (no_controlfk=? AND id_consecutivo=?)" )) {
            $stmt->bind_param('ii',$no_control,$registro); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}	
//funciones empresa

function contar_empresa($mysqli,$No_control){//verificar el max de empresas permitidas
    try{
        $query="SELECT codigo_empresa FROM datos_empresa  WHERE no_controlfk=$No_control";
        if ($stmt = $mysqli->query($query)) {
            if ($stmt->num_rows>=4)
                return true;
            else
                return false;
        }

    }catch(Exception $e){
        return FALSE;
    }

}
	
function guardar_dt_empresa($mysqli,$no_control,$nombre,$giro,$organismo,$razon_social,$telefono,$email,$web,$nombre_jefe,$puesto,$año_ingreso,$calle,$no_domicilio,$codigo_estadofk,$codigo_municipiofk,$medio_busqueda,$tiempo_busqueda){//nueva empresa
    try{    
        if ($stmt = $mysqli->prepare("INSERT INTO datos_empresa (no_controlfk,nombre,giro,organismo,razon_social,telefono,email,web,nombre_jefe,puesto,año_ingreso,calle,no_domicilio,codigo_estadofk,codigo_municipiofk,medio_busqueda,tiempo_busqueda) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")) {
            $stmt->bind_param('issssssssssssssss', $no_control,$nombre,$giro,$organismo,$razon_social,$telefono,$email,$web,$nombre_jefe,$puesto,$año_ingreso,$calle,$no_domicilio,$codigo_estadofk,$codigo_municipiofk,$medio_busqueda,$tiempo_busqueda); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}	

function id_empresa($mysqli,$no_control){//buscar id de la ultima empresa insertada
try{
    $query="SELECT MAX(codigo_empresa) AS id FROM datos_empresa where no_controlfk=$no_control";
    if ($stmt = $mysqli->query($query)) { 
        $row = $stmt->fetch_assoc();
        $stmt->close();
        return $row;
    }else
        return FALSE;
}catch(Exception $e){
    return FALSE;
}

}
function guardar_requisito($mysqli,$no_control,$codigo_empresafk,$requisito){//nueva requisito
    try{
        if ($stmt = $mysqli->prepare("INSERT INTO requesitos_contratacion(no_controlfk,codigo_empresafk,requisito) VALUES (?,?,?)")) {
            $stmt->bind_param('iss',$no_control,$codigo_empresafk,$requisito); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
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



function actualizar_dt_empresa($mysqli,$no_control,$empresa,$nombre,$giro,$organismo,$razon_social,$telefono,$email,$web,$nombre_jefe,$puesto,$año_ingreso,$calle,$no_domicilio,$codigo_estadofk,$codigo_municipiofk,$medio_busqueda,$tiempo_busqueda){//actualizar carrera
    try{
       if ($stmt = $mysqli->prepare("UPDATE datos_empresa SET nombre=?,giro=?,organismo=?,razon_social=?, telefono=?, email=?, web=?, nombre_jefe=?, puesto=?, año_ingreso=?, calle=?, no_domicilio=?, codigo_estadofk=?, codigo_municipiofk=?, medio_busqueda=?, tiempo_busqueda=? where (no_controlfk=? AND codigo_empresa=?)")) {
           $stmt->bind_param('ssssssssssssssssii',$nombre,$giro,$organismo,$razon_social,$telefono,$email,$web,$nombre_jefe,$puesto,$año_ingreso,$calle,$no_domicilio,$codigo_estadofk,$codigo_municipiofk,$medio_busqueda,$tiempo_busqueda,$no_control,$empresa); 
           $stmt->execute();    // Ejecuta la consulta preparada.
           if($stmt->affected_rows >0){
               $stmt->close();
               return true;}
           else{
               $stmt->close();
               return false;}
       }else 
           return FALSE;
   }catch(Exception $e){
       return FALSE;
   }

}

function borrar_requisitos_empresa($mysqli,$No_control,$codigo_empresa){//datos sw
    try{
        if ($stmt = $mysqli->prepare("DELETE  FROM requesitos_contratacion WHERE (no_controlfk=? AND codigo_empresafk=?)")) {
        $stmt->bind_param('ii', $No_control,$codigo_empresa);  // Une “$no:control” al parámetro.
        $stmt->execute();    // Ejecuta la consulta preparada.
        if($stmt->affected_rows >0){
            $stmt->close();
            return true;}
        else{
            $stmt->close();
            return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function borrar_empresa($mysqli,$no_control,$codigo_empresafk){//borrar empresa
    try{
        if ($stmt = $mysqli->prepare("DELETE FROM datos_empresa WHERE (no_controlfk=? AND codigo_empresa=?)")) {
            $stmt->bind_param('ii',$no_control,$codigo_empresafk); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function guardar_historial($mysqli,$no_control,$codigo_empresafk){//nueva requisito
    try{
        if ($stmt = $mysqli->prepare("INSERT INTO historial_laboral(no_controlfk,nombre,telefono,web,email ) SELECT datos_empresa.no_controlfk,datos_empresa.nombre,datos_empresa.telefono, datos_empresa.web, datos_empresa.email FROM datos_empresa WHERE (no_controlfk=? AND codigo_empresa=?)")) {
            $stmt->bind_param('ii',$no_control,$codigo_empresafk); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function dt_empresa_guardar($mysqli,$No_control,$codigo_empresa){//datos empresa todos
    try{$query="SELECT nombre, telefono, web, email FROM datos_empresa WHERE (no_controlfk=$No_control AND codigo_empresa=$codigo_empresa)";
        if ($stmt = $mysqli->query($query)) {
           return $stmt;
       }else
           return FALSE;
    }  catch (Exception $e){
        return FALSE;
    }

}


function dt_historial($no_control,$mysqli){
    try{
        $query='select id_consecutivo,nombre,email,web,telefono from historial_laboral where no_controlfk='.$no_control;
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}


function actualizar_historial($mysqli,$no_control,$nombre,$tel,$web,$email,$registro){//actualizar historial
    try{
        if ($stmt = $mysqli->prepare("UPDATE historial_laboral SET nombre=?,telefono=?,web=?,email=? where (no_controlfk=? AND id_consecutivo=?)" )) {
            $stmt->bind_param('ssssii',$nombre,$tel,$web,$email,$no_control,$registro); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function borrar_historial($mysqli,$no_control,$registro){//borrar empresa
    try{
        if ($stmt = $mysqli->prepare("DELETE FROM historial_laboral WHERE (no_controlfk=? AND id_consecutivo=?)")) {
            $stmt->bind_param('ii',$no_control,$registro); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }  catch (Exception $e){
        return FALSE;
    }

}

function guardar_historial_nuev($mysqli,$no_control,$nombre,$telefono,$web,$email){//nueva requisito
    try{
        if ($stmt = $mysqli->prepare("INSERT INTO historial_laboral(no_controlfk,nombre,telefono,web,email ) VALUES (?,?,?,?,?)")) {
            $stmt->bind_param('issss',$no_control,$nombre,$telefono,$web,$email); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function dt_social($no_control,$mysqli){
    try{
        $query='select id_consecutivo, nombre,tipo from actividad_social where no_controlfk='.$no_control;
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}


function guardar_social($mysqli,$no_control,$nombre,$tipo){//nueva requisito
    try{
        if ($stmt = $mysqli->prepare("INSERT INTO actividad_social(no_controlfk,nombre,tipo ) VALUES (?,?,?)")) {
            $stmt->bind_param('iss',$no_control,$nombre,$tipo); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}	

function borrar_social($mysqli,$no_control,$registro){//borrar social
    try{
        if ($stmt = $mysqli->prepare("DELETE FROM actividad_social WHERE (no_controlfk=? AND id_consecutivo=?)")) {
            $stmt->bind_param('ii',$no_control,$registro); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }  catch (Exception $e){
        return FALSE;
    }

}

function guardar_foto_egresado($mysqli,$no_control,$img){//nueva requisito
    try{
        if ($stmt = $mysqli->prepare("update datos_egresado set imagen=? where no_control=?")) {
            $stmt->bind_param('si',$img,$no_control); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return 3;}
        }else
            return 2;
    }catch(Exception $e){
        return FALSE;
    }

}	


function cargar_foto($mysqli,$no_control){
    try{
        if ($stmt = $mysqli->query("SELECT imagen FROM datos_egresado WHERE  no_control=".$no_control." limit 1")) {
            $dato=$stmt->fetch_assoc();
            $img='"fotos_egresados/'.$dato['imagen'].'"';
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
	
function all_requisitos_empresa($mysqli,$No_control,$empresa){//datos social
    try{    
        $query="SELECT  requisito FROM requesitos_contratacion WHERE (no_controlfk=".$No_control." AND codigo_empresafk=$empresa)";
        if ($stmt = $mysqli->query($query)) {
            return $stmt;
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}

function buscar_foto($mysqli,$no_control){
    try{ 
        $query="SELECT imagen FROM datos_egresado WHERE  no_control=$no_control";       
        if ($stmt = $mysqli->query($query)) {
            return $stmt;
        }else 
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }

}
	
function borrar_foto($url){
    try{
        $url='..\fotos_egresados\\'.$url;
	if(unlink($url))
            return true;
	else 
            return false;
    }catch(Exception $e){
        return FALSE;
    }

}	
function dt_posgrado($no_control,$mysqli){
    try{
        $query='select id_posgrado,posgrado,nombre,escuela,titulado from posgrado where no_controlfk='.$no_control;
        if($resultado=$mysqli->query($query)){
            return $resultado;           
        }else
            return  FALSE;
        
        
    }catch(Exception $e){
        return FALSE;
    }
}		
function borrar_posgrado($mysqli,$no_control,$registro){//borrar sw
    try{
        if ($stmt = $mysqli->prepare("DELETE FROM posgrado WHERE (no_controlfk=? AND id_posgrado=?)" )) {
            $stmt->bind_param('ii',$no_control,$registro); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}		
function guardar_posgrado($mysqli,$no_control,$posgrado,$nombre,$escuela,$titulado){//borrar social
    try{
        if ($stmt = $mysqli->prepare("Insert into posgrado(no_controlfk, posgrado, nombre, escuela, titulado) values(?,?,?,?,?) ")) {
            $stmt->bind_param('issss',$no_control,$posgrado,$nombre,$escuela,$titulado); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else
            return FALSE;
    }catch(Exception $E){
        return FALSE;
    }

}

function actualizar_residencia($mysqli,$no_control,$residencia){//borrar social
    try{
        if ($stmt = $mysqli->prepare("Update datos_egresado set experiencia_residencia=? where no_control=? ")) {
            $stmt->bind_param('ii',$residencia,$no_control); 
            $stmt->execute();    // Ejecuta la consulta preparada.
            if($stmt->affected_rows >0){
                $stmt->close();
                return true;}
            else{
                $stmt->close();
                return false;}
        }else 
            return FALSE;
    }catch(Exception $E){
        return FALSE;
    }

}

function validarNombre($cadena){//cortesia de Juan Valencia Escalante  en http://www.jveweb.net/archivo/2011/07/algunas-expresiones-regulares-y-como-usarlas-en-php.html
        try{
        $cadena=  trim($cadena);
        if(strlen( $cadena)<=40){
            $pattern = "/^[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*$/D";
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
function validarFecha($cadena){
    try{    
        $fecha=  explode('-', $cadena);
        if(checkdate($fecha[1], $fecha[2], $fecha[0]))
            return 1;
        else
            return 0;
    }catch (Exception $e){
           return 3;
       }    
}  

function validarEstado($estado,$mysqli){
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

function validarCarrera($carrera,$mysqli){
   try{
        $query='select codigo_carrera from carrera where codigo_carrera="'.$carrera.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows>0){
                return 1;
            }else
                return 0;
        
        }else {
            return 3;
        }
    }catch (Exception $e){
            return FALSE;
        }  
}

function validarIdioma($idioma,$mysqli){
   try{
        $query='select codigo_idioma from idioma where codigo_idioma="'.$idioma.'"';
        if($resultado=$mysqli->query($query)){
            if($resultado->num_rows>0){
                return 1;
            }else
                return 0;
        
        }else
            return FALSE;
    }catch (Exception $e){
            return FALSE;
        }  
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
function validarPosgrado($cadena){
    try{
       $posgrados=array('Maestría','Doctorado'); 
       $x=0;
       while($x<count($posgrados)){
           if($posgrados[$x]==$cadena)
               return TRUE;
           $x++;
       }
       return FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function validarSocial($social){
    try{
       $sociales=array('GRUPO ESTUDIANTIL','ASOCIACIÓN CIVIL'); 
       $x=0;
       while($x<count($sociales)){
           if($sociales[$x]==$social)
               return TRUE;
           $x++;
       }
       return FALSE;
    }catch(Exception $e){
        return FALSE;
    }
}
function validarEmpresa($nombre,$giro,$organismo,$razon_social,$tel,$email,$web,$jefe,$año_ingreso,$estado,$municipio,$mysqli){
    try{
        $respuesta=array();
        $respuesta['resultado']=FALSE;
        $respuesta['mensaje']='Error de validación';
        if(strlen($nombre)<=40){
            $respuesta['resultado']=TRUE;
            $respuesta['mensaje']='bien';
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Nombre inválido';
            return $respuesta;  
        }
        if(validarNombre($giro)){
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Giro inválido';
            return $respuesta;  
        }
        
        if(validarOrganismo($organismo)){
         
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo Organismo inválido';
            return $respuesta;  
        }
        
        if(validarRazon_social($razon_social)){
          
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo razón social inválido';
            return $respuesta;  
        }
        if(validarTelefono($tel)){
          
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo teléfono  inválido';
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
        if(validarNombre($jefe)){
         
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo jefe  inválido';
            return $respuesta;  
        }
        if(validarFecha($año_ingreso)){
         
        }else{
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo año de ingreso  inválido';
            return $respuesta;  
        }
        $validar_estado=validarEstado($estado,$mysqli);
        if($validar_estado==1){
          
        }else{
            if($validar_estado==0){
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo estado  inválido';
            return $respuesta; 
            }
            if($validar_estado==3){
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Error en bd';
            return $respuesta; 
            }
        }
        $validar_mun=validarMun($municipio,$mysqli);
        if($validar_mun==1){
         
        }else{
            if($validar_mun==0){
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Campo municipio  inválido';
            return $respuesta; 
            }
            if($validar_mun==3){
            $respuesta['resultado']=FALSE;
            $respuesta['mensaje']='Error en bd';
            return $respuesta; 
            } 
        }
        return $respuesta;    
        
    }catch(Exception $e){
        return $respuesta;
    }
}

function validarHistorial($nombre,$tel,$email,$web){
    try{
        $respuesta=array();
        $respuesta['resultado']=FALSE;
        $respuesta['mensaje']='error en servidor';
        if(strlen($nombre)<=40){
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
        return $respuesta;    
        
    }catch(Exception $e){
        return $respuesta;
    }
}

function validarOrganismo($organismo){
    $organismos=array('Público','Privado','Social');
    $x=0;
    while($x<count($organismo)){
        if($organismo[$x]==$organismo)
            return TRUE;
        $x++;
    }
    return FALSE;
}
function validarWeb($web){
    {
    if (strlen($web)<=40)
        return (preg_match('/^[http:\/\/|www.|https:\/\/]/i', $web));
    }
}
function validarRazon_social($razon_social){
    $razon_socials=array('Persona Moral','Persona Física');
    $x=0;
    while($x<count($razon_social)){
        if($razon_socials[$x]==$razon_social)
            return TRUE;
        $x++;
    }
    return FALSE;
}


function anti_xss($form){//limpiar formularios recibidos 
        foreach ($form as &$valor):
            $valor=  strip_tags($valor);
            // General
        //sql
            $valor=str_replace("select","",$valor);
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
            $valor=str_replace("<","",$valor);   
            $valor=str_replace(">","",$valor);   
            $valor=str_replace("{","",$valor);   
            $valor=str_replace("}","",$valor);   
            $valor=str_replace("[","",$valor);   
            $valor=str_replace("]","",$valor);   
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

function nuevo_pass($no_control,$viejo_pass,$nuevo_pass,$mysqli){
try{    
    if($stmt=$mysqli->prepare('select password,salt from datos_egresado where no_control=?'))
    {
        $stmt->bind_param('i',$no_control); 
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();
        // Obtiene las variables del resultado.
        $stmt->bind_result($password,$salt);
        $stmt->fetch();
        $viejo_pass=hash('sha512', $viejo_pass . $salt);
        if($viejo_pass==$password){
            $nuevo_salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $nuevo_pass=hash('sha512', $nuevo_pass . $nuevo_salt);
            if($stmt=$mysqli->prepare('update datos_egresado set password=?, salt=? where no_control=?'))
            {
                $stmt->bind_param('sss',$nuevo_pass,$nuevo_salt,$no_control); 
                $stmt->execute();    // Ejecuta la consulta preparada.
                if($stmt->affected_rows >0)
                    return true;
                else
                    return false;
                
            }
            else
                return FALSE;
        }
        else return FALSE;
    }  
    else 
        return false;
}catch(Exception $e){
    return FALSE;
}

}


