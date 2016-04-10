<?php
include 'psl-config.php';   // Ya que functions.php no está incluido.
try{
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$acentos = $mysqli->query("SET NAMES 'utf8'");
}catch(Exception $e){
$mysqli=FALSE;    
}