<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

$form=array();
sleep(3);
if (isset($_POST['form'],$_POST['no_control'],$_POST['registro']))
{
    parse_str($_POST['form'],$form);
    $form=anti_xss($form);
    if(is_numeric($_POST['no_control']))
    {
        if(actualizar_historial($mysqli,$_POST['no_control'],$form['nombre'],$form['tel'],$form['web'],$form['email'],$_POST['registro']))
            echo "1";
        else
            echo "0";
    }
    else
        echo '2';
}
else
    echo "2";//error con el formulario enviado
?>