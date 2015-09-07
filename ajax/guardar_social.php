<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

$form=array();
sleep(3);
if (isset($_POST['form'],$_POST['no_control']))
{
    if(is_numeric($_POST['no_control']))
    {
    parse_str($_POST['form'],$form);
    $form=anti_xss($form);
    if(guardar_social($mysqli,$_POST['no_control'],$form['nombre'],$form['tipo']))
        echo "1";//exito
    else
        echo "0";
    }
    else 
        echo '2';
}
else
    echo "2";//error con el formulario enviado
?>