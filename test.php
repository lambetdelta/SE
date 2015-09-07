<?php

include_once 'includes/functions.php';
//$cad=salt(128,FALSE,TRUE, FALSE).'<br>';
//$pass=  hash('sha512','123');
//$password = hash('sha512', $pass.$cad);
//echo '<br>este es el salt '.$cad;
//echo 'este es el password que se envia por web '.$pass;
//echo '<br>este es el password final guardado en bd '.$password;
////
//$arra=['uno'=>'0','dos'=>'1','tres'=>'2','cuatro'=>'3'];

//foreach ($arra as &$valor):
//    $valor=$valor+1;  
//endforeach;
//
//foreach ($arra as $id=>$valor):
//    echo '<br>este es el valor'.$valor;   
//endforeach;

$array = array(1, 2, 3, 4);


foreach ($array as &$valor) {
    $valor = $valor * 2;
}
unset($valor);

foreach ($array as $id=>$val):
    echo '<br>este es el id'.$id.'este es el valor'.$val;   
endforeach;
