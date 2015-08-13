<?php
include_once 'psl-config.php';   // Ya que functions.php no está incluido.
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$acentos = $mysqli->query("SET NAMES 'utf8'");;?>