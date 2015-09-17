<?php

include_once 'includes/functions.php';
$salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
echo '<br>este es el salt '.$salt.'<br>';
$pass=  hash('sha512','123');
$password = hash('sha512', $pass.$salt);
echo '<br>este es el salt '.$salt;
echo '<br>este es el password que se envia por web '.$pass;
echo '<br>este es el password final guardado en bd '.$password;


