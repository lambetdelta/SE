<?php

include_once 'includes/functions.php';
echo 'salt'.$cad=salt(128,FALSE,TRUE, FALSE).'<br>';
$pass=  hash('sha512','123');
$password = hash('sha512', $pass.'7czl8buuz8xny7dlod1jcumsd6336u1rphnwd7vu6at7kwua0hlhmq7pnejortu00zwztm510yldfrdh4g09d30a225jomo9d6r2m2s6uts6hj3ii5vefx6s92zqg7m1');
echo 'este es el password que se envia por web'.$pass;
echo '<br>este es el password final guardado en bd'.$password;

if (strcmp ($pass ,'3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'  ) == 0) { echo'si'; }