<?php

include_once 'includes/functions.php';
$salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
echo '<br>este es el salt '.$salt.'<br>';
$pass=  hash('sha512','1');
$password = hash('sha512','3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'.'uwicq37ypirg9pf508vqo7spkcppewz01rogiszt6p160093f233ue0ul07802s54iparn67ko5rcxcptulaavm27jckua9zu6l6p1y38nu8e8bh830e3h1q16bo6a57');
echo '<br>este es el salt '.$salt;
echo '<br>este es el password que se envia por web '.$pass;
echo '<br>este es el password final guardado en bd '.$password;


