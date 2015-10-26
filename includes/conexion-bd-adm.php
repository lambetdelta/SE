<?php
include_once 'psl-config-adm.php';   // Ya que functions.php no está incluido.
if($mysqli = new mysqli(HOST_ADM, USER_ADM, PASSWORD_ADM, DATABASE_ADM))
    $acentos = $mysqli->query("SET NAMES 'utf8'");
else
    echo 'Sin Conexión a BD';


