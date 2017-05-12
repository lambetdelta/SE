<?php
/* Cualquier duda repecto al código o en que diablos estaba pensando cuando lo hice :) enviar un correo 
 *  con el asunto SE a la siguiente direccion lambetdelta@hotmail.com con el  Ing. Osvaldo Uriel Garcia Gomez*/ 
include_once '../includes/conexion-bd-adm.php';
include_once '../includes/functions.php';
if (($gestor = fopen("estados.CSV", "r")) !== FALSE) {
    while (($datos = fgetcsv($gestor)) !== FALSE) {
        $query='insert into estado(codigo_estado,nombre) values("'.utf8_encode($datos[0]).'","'.utf8_encode($datos[1]).'")';
       if($mysqli->query($query)){
           if($mysqli->affected_row>0)
                echo 'cargado el estado'.utf8_encode($datos[1]).'<br>';
       }  else {
           
       echo 'error en el estado'.utf8_encode($datos[1]).'<br>';}
    }
    fclose($gestor);
}
if (($gestor = fopen("municipios.CSV", "r")) !== FALSE) {
    while (($datos = fgetcsv($gestor)) !== FALSE) {
        $query='insert into municipio(codigo_municipio,nombre,codigo_estadofk) values("'.utf8_encode($datos[2]).'","'.utf8_encode($datos[3]).'","'.utf8_encode($datos[0]).'")';
       if($mysqli->query($query)){
           if($mysqli->affected_rows>0)
                echo 'cargado el municipio'.utf8_encode($datos[3]).'<br>';
       }  else {
           
       echo 'error en el municipio'.utf8_encode($datos[3]).'<br>';}
    }
    fclose($gestor);
}