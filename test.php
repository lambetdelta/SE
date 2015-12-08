<?php

include 'includes/db_connect.php';
include 'includes/functions_adm.php';
$nombre='osvaldo uriel garcia gomez';

 $nombre=  explode(' ', $nombre);//cuando el dato es un nombre que puede tenerla secuencia nombre apellido apellido, nombre nombre apellido, nombre nombre nombre , o mas combianciones con n nombres
        $nombre_completo=$nombre[0];
        for($i=1;$i<(count($nombre)-2);$i++) {
            $nombre_completo=$nombre_completo.' '.$nombre[$i];
        }
        echo $nombre_completo.'apellido_m '. $nombre[count($nombre)-2].'apellido_ '. $nombre[count($nombre)-1].'<br>';
            for($i=1;$i<(count($nombre)-1);$i++) 
            $nombre_completo=$nombre_completo.' '.$nombre[$i];
            echo $nombre_completo.' apellido_'. $nombre[count($nombre)-1].'<br>';//busca por medio de dos nombres y el primer apellido
$nombres=array('IGN','INT','OMAC','LEXCORP','PLANET','COca','Light','CELL','NOWHERE','INIS','OMARI');
$giro=array('armas','sistemas','mercadotecnia','ventas','automotriz','educación','diseño web','redes empresariales','soporte tecnico','bancario','marina');
////$x=1;
//$fecha=array('2016-1-10','2012-03-12','2017-03-12','2011-2-1','2010-1-1','1999-1-1','1998-1-1');

$x=1;
$no_control=10947444;
while($x<21){
    $query='Insert into datos_egresado(no_control,nombre) values('.$no_control.',"eco")';
$mysqli->query($query);
//  echo 
//  $no_control=$no_control+1;
  $x=$x+1;
  $no_control=$no_control+1;
//  
}
//echo $x;
//$salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
//echo '<br>este es el salt '.$salt.'<br>';
//$pass=  hash('sha512','1');
//$password = hash('sha512',$pass.$salt);
//echo '<br>este es el salt '.$salt;
//echo '<br>este es el password que se envia por web '.$pass;
//echo '<br>este es el password final guardado en bd '.$password;


