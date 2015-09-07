<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
sleep(5);
$form = array();
if (isset($_POST['form'], $_POST['no_control'])) 
{//guardar datos de egresado
    if(is_numeric($_POST['no_control']))
    {
        parse_str($_POST['form'], $form);
        $form=anti_xss($form);
        $resultado = actualizar_egresado($mysqli, $form['nombre'], $form['apellido_m'], $form['apellido_p'], $form['curp'], $form['fecha_nac'], $form['tel'], $form['email'], $form['calle'], $form['no_casa'], $form['estado'], $form['municipio'], $_POST['no_control']);
        echo $resultado;
    }
    else 
        echo '2';
}
else 
    echo '2';

?>