<?php
include_once 'psl-config.php';   // Ya que functions.php no está incluido.
if($mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE))
    $acentos = $mysqli->query("SET NAMES 'utf8'");
else
    echo 'Sin Conexión a BD';