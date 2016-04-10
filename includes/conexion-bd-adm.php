<?php
include_once 'psl-config-adm.php';
try{
$mysqli = new mysqli(HOST_ADM, USER_ADM, PASSWORD_ADM, DATABASE_ADM);
$acentos = $mysqli->query("SET NAMES 'utf8'");
}catch(Exception $e){
$mysqli=FALSE;    
}